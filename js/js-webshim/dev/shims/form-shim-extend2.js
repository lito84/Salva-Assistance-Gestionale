webshims.register('form-shim-extend2', function($, webshims, window, document, undefined, options){
	"use strict";
	var isNumber = function(string){
		return (typeof string == 'number' || (string && string == string * 1));
	};
	var support = webshims.support;
//support getSetAttribute
	var supportGetSetAttribute = !(('getSetAttribute' in  $.support) && !$.support.getSetAttribute);
//submitbubbles for IE6-IE8
	var supportSubmitBubbles = !('submitBubbles' in $.support) || $.support.submitBubbles;
	var addSubmitBubbles = function(form){
		if (!supportSubmitBubbles && form && typeof form == 'object' && !form._submit_attached ) {

			$.event.add( form, 'submit._submit', function( event ) {
				event._submit_bubble = true;
			});

			form._submit_attached = true;
		}
	};
	if(!supportSubmitBubbles && $.event.special.submit){

		$.event.special.submit.setup = function() {
			// Only need this for delegated form submit events
			if ( $.nodeName( this, "form" ) ) {
				return false;
			}

			// Lazy-add a submit handler when a descendant form may potentially be submitted
			$.event.add( this, "click._submit keypress._submit", function( e ) {
				// Node name check avoids a VML-related crash in IE (#9807)
				var elem = e.target,
					form = $.nodeName( elem, 'input' ) || $.nodeName( elem, 'button' ) ? $.prop(elem, 'form') : undefined;
				addSubmitBubbles(form);

			});
			// return undefined since we don't need an event listener
		};
	}

	webshims.reflectProperties(['input'], ['pattern']);


	if( !('maxLength' in document.createElement('textarea')) ){
		var constrainMaxLength = (function(){
			var timer;
			var curLength = 0;
			var lastElement = $([]);
			var max = 1e9;
			var constrainLength = function(){
				var nowValue = lastElement.prop('value');
				var nowLen = nowValue.length;
				if(nowLen > curLength && nowLen > max){
					nowLen = Math.max(curLength, max);
					lastElement.prop('value', nowValue.substr(0, nowLen ));
				}
				curLength = nowLen;
			};
			var remove = function(){
				clearTimeout(timer);
				lastElement.off('.maxlengthconstraint');
			};
			return function(element, maxLength){
				remove();
				if(maxLength > -1){
					max = maxLength;
					curLength = $.prop(element, 'value').length;
					lastElement = $(element);
					lastElement.on({
						'keydown.maxlengthconstraint keypress.maxlengthconstraint paste.maxlengthconstraint cut.maxlengthconstraint': function(e){
							setTimeout(constrainLength, 0);
						},
						'keyup.maxlengthconstraint': constrainLength,
						'blur.maxlengthconstraint': remove
					});
					timer = setInterval(constrainLength, 200);
				}
			};
		})();

		constrainMaxLength.update = function(element, maxLength){
			if($(element).is(':focus')){
				if(!maxLength){
					maxLength = $.prop(element, 'maxlength');
				}
				constrainMaxLength(element, maxLength);
			}
		};

		$(document).on('focusin', function(e){
			var maxLength;
			if(e.target.nodeName == "TEXTAREA" && (maxLength = $.prop(e.target, 'maxlength')) > -1){
				constrainMaxLength(e.target, maxLength);
			}
		});

		webshims.defineNodeNameProperty('textarea', 'maxlength', {
			attr: {
				set: function(val){
					this.setAttribute('maxlength', ''+val);
					constrainMaxLength.update(this);
				},
				get: function(){
					var ret = this.getAttribute('maxlength');
					return ret == null ? undefined : ret;
				}
			},
			prop: {
				set: function(val){
					if(isNumber(val)){
						if(val < 0){
							throw('INDEX_SIZE_ERR');
						}
						val = parseInt(val, 10);
						this.setAttribute('maxlength', val);
						constrainMaxLength.update(this, val);
						return;
					}
					this.setAttribute('maxlength', '0');
					constrainMaxLength.update(this, 0);
				},
				get: function(){
					var val = this.getAttribute('maxlength');
					return (isNumber(val) && val >= 0) ? parseInt(val, 10) : -1;

				}
			}
		});
		webshims.defineNodeNameProperty('textarea', 'maxLength', {
			prop: {
				set: function(val){
					$.prop(this, 'maxlength', val);
				},
				get: function(){
					return $.prop(this, 'maxlength');
				}
			}
		});
	}

	if(!supportGetSetAttribute && $('<form novalidate></form>').attr('novalidate') == null){
		webshims.defineNodeNameProperty('form', 'novalidate', {
			attr: {
				set: function(val){
					this.setAttribute('novalidate', ''+val);
				},
				get: function(){
					var ret = this.getAttribute('novalidate');
					return ret == null ? undefined : ret;
				}
			}
		});
	}


	if(!support.fieldsetdisabled || !support.fieldsetelements){
		(function(){
			if(!support.fieldsetdisabled){
				var hasIsDisabled = 'isDisabled' in document.createElement('div');
				var isFieldsetGroup = {
					fieldset: 1,
					FIELDSET: 1
				};
				var disableElementsSel = 'input, textarea, select, button';

				var isDisabledChild = function(elem){
					if(hasIsDisabled && !elem.isDisabled){
						return false;
					}
					return $.find.matchesSelector(elem, 'fieldset[disabled] *' );
				};
				var isDisabledChildFilter = hasIsDisabled ?
					function(){
						return this.isDisabled && $.find.matchesSelector(this, 'fieldset[disabled] *' );
					} :
					'fieldset[disabled] *';
				var isEnableChildFilter = hasIsDisabled ?
					function(){
						return !this.isDisabled && !$.find.matchesSelector(this, 'fieldset[disabled] *' );
					} :
					':not(fieldset[disabled] *)';

				$.extend($.expr[":"], {
					"enabled": function( elem ) {
						return isFieldsetGroup[elem.nodeName] ? (webshims.contentAttr(elem, 'disabled') == null && !isDisabledChild(elem)) : elem.disabled === false;
					},

					"disabled": function( elem ) {
						return isFieldsetGroup[elem.nodeName] ? (webshims.contentAttr(elem, 'disabled') != null || isDisabledChild(elem)) : elem.disabled === true;
					}
				});


				var groupControl = {
					disable: function(){
						if(!this.disabled){
							webshims.data(this, 'groupedisabled', true);
							this.disabled = true;
						}
					},
					enable: function(){
						if(this.disabled && webshims.data(this, 'groupedisabled')){
							webshims.data(this, 'groupedisabled', false);
							this.disabled = false;
						}
					}
				};

				$(window).on('unload', function(){
					$(disableElementsSel).each(groupControl.enable);
				});

				webshims.defineNodeNamesBooleanProperty(['fieldset'], 'disabled', {
					set: function(value){
						value = !!value;

						if(value){
							$(this.querySelectorAll(disableElementsSel)).each(groupControl.disable);

						} else if(!isDisabledChild(this)){
							var elements = $(this.querySelectorAll(disableElementsSel));

							if( this.querySelector('fieldset[disabled]') ){
								elements = elements.filter(isEnableChildFilter);
							}

							elements.each(groupControl.enable);
						}
					},
					initAttr: true,
					useContentAttribute: true
				});

				['input', 'textarea', 'select', 'button'].forEach(function(nodeName){
					var desc = webshims.defineNodeNameProperty(nodeName, 'disabled', {
						prop: {
							set: function(value){
								if(value){
									webshims.data(this, 'groupedisabled', false);
									desc.prop._supset.call(this, value);

								} else if(isDisabledChild(this)){
									webshims.data(this, 'groupedisabled', true);
									desc.prop._supset.call(this, true);
								} else {
									webshims.data(this, 'groupedisabled', false);
									desc.prop._supset.call(this, value);
								}
							},
							get: function(){
								var ret = desc.prop._supget.call(this);
								return ret ? !webshims.data(this, 'groupedisabled') : ret;
							}
						},
						removeAttr: {
							value: function(){
								desc.prop.set.call(this, false);
							}
						}
					});
				});

				webshims.addReady(function(context){

					$(context)
						.filter(isDisabledChildFilter)
						.find(disableElementsSel)
						.each(groupControl.disable)
					;
				});
			}


			(function(prop, undefined){
				var isForm = {form: 1, FORM: 1};
				$.prop = function(elem, name, value){
					var ret;
					if(elem && elem.nodeType == 1 && value === undefined && isForm[elem.nodeName] && elem.id){
						ret = document.getElementsByName(name);
						if(!ret || !ret.length){
							ret = document.getElementById(name);
						}
						if(ret){
							ret = $(ret).filter(function(){
								return $.prop(this, 'form') == elem;
							}).get();
							if(ret.length){
								return ret.length == 1 ? ret[0] : ret;
							}
						}
					}
					return prop.apply(this, arguments);
				};
			})($.prop, undefined);

			var removeAddedElements = function(form){
				var elements = $.data(form, 'webshimsAddedElements');
				if(elements){
					elements.remove();
					$.removeData(form, 'webshimsAddedElements');
				}
			};

			var getAssociatedForm = function () {
				var form = webshims.contentAttr(this, 'form');
				if(form){
					form = document.getElementById(form);
					if(form && !$.nodeName(form, 'form')){
						form = null;
					}
				}
				return form || this.form;
			};
			webshims.defineNodeNamesProperty(['input', 'textarea', 'select', 'button', 'fieldset'], 'form', {
				prop: {
					get: getAssociatedForm,
					writeable: false
				}
			});

			webshims.defineNodeNamesProperty(['form'], 'elements', {
				prop: {
					get: function(){
						//TODO: cache + perftest
						var sel, addElements, detachElements, formElements, i, len;
						var id = this.id;
						var elements = [];
						if(id){
							detachElements = $.data(this, 'webshimsAddedElements');
							if(detachElements){
								detachElements.detach();
							}
						}

						formElements = this.elements;

						if(this.querySelector('input[form], select[form], textarea[form]')){
							for(i = 0, len = formElements.length; i < len; i++){
								if(getAssociatedForm.call(formElements[i]) == this){
									elements.push(formElements[i]);
								}
							}
						} else {
							elements = $.makeArray(formElements);
						}

						if(id){
							sel = 'input[form="'+ id +'"], select[form="'+ id +'"], textarea[form="'+ id +'"], button[form="'+ id +'"], fieldset[form="'+ id +'"]';
							addElements = document.querySelectorAll(sel) || [];
							if(addElements.length){
								elements = $(elements).add(addElements).get();

							}
							if(detachElements){
								detachElements.appendTo(this);
							}
						}
						return elements;
					},
					writeable: false
				}
			});



			$(function(){
				var stopPropagation = function(e){
					e.stopPropagation();
				};
				var submitters = {
					image: 1,
					submit: 1
				};
				$(document).on('submit', function(e){

					if(!e.isDefaultPrevented()){
						var form = e.target;
						var id = form.id;
						var elements;


						if(id){
							removeAddedElements(form);
							elements = document.querySelectorAll('input[form="'+ id +'"], select[form="'+ id +'"], textarea[form="'+ id +'"]');
							elements = $(elements)
								.filter(function(){
									return !this.disabled && this.name && this.form != form;
								})
								.clone()
							;
							if(elements.length){
								$.data(form, 'webshimsAddedElements', $('<div class="webshims-visual-hide" />').append(elements).appendTo(form));
								setTimeout(function(){
									removeAddedElements(form);
								}, 9);
							}
							elements = null;
						}
					}
				});


				$(document).on('click', function(e){
					if(submitters[e.target.type] && !e.isDefaultPrevented() && webshims.contentAttr(e.target, 'form')){
						var trueForm = $.prop(e.target, 'form');
						var formIn = e.target.form;
						var clone;
						if(trueForm && trueForm != formIn){
							clone = $(e.target)
								.clone()
								.removeAttr('form')
								.addClass('webshims-visual-hide')
								.on('click', stopPropagation)
								.appendTo(trueForm)
							;
							if(formIn){
								e.preventDefault();
							}
							addSubmitBubbles(trueForm);
							clone.trigger('click');
							setTimeout(function(){
								clone.remove();
								clone = null;
							}, 9);
						}
					}
				});
			});

			if(!$.fn.finish && parseFloat($.fn.jquery, 10) < 1.9){
				var rCRLF = /\r?\n/g,
					rinput = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,
					rselectTextarea = /^(?:select|textarea)/i;
				$.fn.serializeArray = function() {
					return this.map(function(){
						var elements = $.prop(this, 'elements');
						return elements ? $.makeArray( elements ) : this;
					})
						.filter(function(){
							return this.name && !$(this).is(':disabled') &&
								( this.checked || rselectTextarea.test( this.nodeName ) ||
									rinput.test( this.type ) );
						})
						.map(function( i, elem ){
							var val = $( this ).val();

							return val == null ?
								null :
								$.isArray( val ) ?
									$.map( val, function( val, i ){
										return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
									}) :
								{ name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
						}).get();
				};
			}


			if(!support.fieldsetelements){
				webshims.defineNodeNamesProperty(['fieldset'], 'elements', {
					prop: {
						get: function(){
							//add listed elements without keygen, object, output
							return this.querySelectorAll('input, select, textarea, button, fieldset') || [];
						},
						writeable: false
					}
				});
			}

		})();
	}

	if($('<input />').prop('labels') == null){
		webshims.defineNodeNamesProperty('button, input, keygen, meter, output, progress, select, textarea', 'labels', {
			prop: {
				get: function(){
					if(this.type == 'hidden'){return null;}
					var id = this.id;
					var labels = $(this)
							.closest('label')
							.filter(function(){
								var hFor = (this.attributes['for'] || {});
								return (!hFor.specified || hFor.value == id);
							})
						;

					if(id) {
						labels = labels.add(document.querySelectorAll('label[for="'+ id +'"]'));
					}
					return labels.get();
				},
				writeable: false
			}
		});
	}

	if(!('value' in document.createElement('progress'))){
		(function(){

			var nan = parseInt('NaN', 10);

			var updateProgress = function(progress){
				var position = $.prop(progress, 'position');

				$.attr(progress, 'data-position', position);
				$('> span', progress).css({width: (position < 0 ?  100 : position * 100) +'%'});
			};
			var desc = {
				position: {
					prop: {
						get: function(){
							var max;
							//jQuery 1.8.x try's to normalize "0" to 0
							var val = this.getAttribute('value');
							var ret = -1;

							val = val ? (val * 1) : nan;
							if(!isNaN(val)){
								max = $.prop(this, 'max');
								ret = Math.max(Math.min(val / max, 1), 0);
								if(updateProgress.isInChange){
									$.attr(this, 'aria-valuenow', ret * 100);
									if(updateProgress.isInChange == 'max'){
										$.attr(this, 'aria-valuemax', max);
									}
								}
								$(this).removeClass('ws-indeterminate');
							} else if(updateProgress.isInChange) {
								$(this).removeAttr('aria-valuenow').addClass('ws-indeterminate');
							}
							return ret;
						},
						writeable: false
					}
				}
			};

			$.each({value: 0, max: 1}, function(name, defValue){
				var removeProp = (name == 'value' && !$.fn.finish);
				desc[name] = {
					attr: {
						set: function(value){
							var ret = desc[name].attr._supset.call(this, value);
							updateProgress.isInChange = name;
							updateProgress(this);
							updateProgress.isInChange = false;
							return ret;
						}
					},
					removeAttr: {
						value: function(){
							this.removeAttribute(name);
							if(removeProp){
								try {
									delete this.value;
								} catch(er){}
							}
							updateProgress.isInChange = name;
							updateProgress(this);
							updateProgress.isInChange = false;
						}
					},
					prop: {
						get: function(){
							var max;
							var ret = (desc[name].attr.get.call(this) * 1);
							if(ret < 0 || isNaN(ret)){
								ret = defValue;
							} else if(name == 'value'){
								ret = Math.min(ret, $.prop(this, 'max'));
							} else if(ret === 0){
								ret = defValue;
							}
							return ret;
						},
						set: function(value){
							value = value * 1;
							if(isNaN(value)){
								webshims.error('Floating-point value is not finite.');
							}
							return desc[name].attr.set.call(this, value);
						}
					}
				};
			});

			webshims.createElement(
				'progress',
				function(){
					var labels = $(this)
							.attr({role: 'progressbar', 'aria-valuemin': '0'})
							.html('<span class="progress-value" />')
							.jProp('labels')
							.map(function(){
								return webshims.getID(this);
							})
							.get()
						;
					if(labels.length){
						$.attr(this, 'aria-labelledby', labels.join(' '));
					} else {
						webshims.info("you should use label elements for your prgogress elements");
					}
					$(this).addClass('ws-style');
					if($(this).css('direction') == 'rtl'){
						$(this).addClass('ws-is-rtl');
					}
					updateProgress.isInChange = 'max';
					updateProgress(this);
					updateProgress.isInChange = false;
				},
				desc
			);

		})();
	}

	if(!('setSelectionRange' in document.createElement('input'))){
		(function(){
			var getSelection = function(elem, getStart){
				var range, value, normalizedValue, textInputRange, len, endRange;
				var start = 0;
				var end = 0;
				if (document.selection && (range = document.selection.createRange()) && range.parentElement() == elem) {
					value = $.prop(elem, 'value');
					len = value.length;
					normalizedValue = value.replace(/\r\n/g, "\n");

					textInputRange = elem.createTextRange();
					textInputRange.moveToBookmark(range.getBookmark());


					endRange = elem.createTextRange();
					endRange.collapse(false);

					if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
						start = end = len;
					} else {
						if(getStart){
							start = -textInputRange.moveStart("character", -len);
							start += normalizedValue.slice(0, start).split("\n").length - 1;
						} else {
							if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
								end = len;
							} else {
								end = -textInputRange.moveEnd("character", -len);
								end += normalizedValue.slice(0, end).split("\n").length - 1;
							}
						}

					}
				}
				return {
					start: start,
					end: end
				};
			};

			['input', 'textarea'].forEach(function(name){
				var isTextarea = name == 'textarea';
				//email?
				var allowedTypes = {text: 1, search: 1, url: 1, tel: 1, password: 1, email: 1};
				var error = 'InvalidStateError: An attempt was made to use an object that is not, or is no longer, usable. selection not allowed on this type';
				webshims.defineNodeNameProperties(name, {
					selectionStart: {
						get: function(){
							if(isTextarea || allowedTypes[$.prop(this, 'type')]){
								return getSelection(this, true).start;
							}
							webshims.error(error);
						},
						set: function(v){
							if(this.createTextRange && (isTextarea || allowedTypes[$.prop(this, 'type')])){
								var range = this.createTextRange();
								range.collapse(true);
								range.moveStart('character', v);
								range.moveEnd('character', $.prop(this, 'selectionEnd'));
								if($(this).is(':focus')){
									range.select();
								}
							} else {
								webshims.error(error);
							}
						}
					},
					selectionEnd: {
						get: function(){
							if(isTextarea || allowedTypes[$.prop(this, 'type')]){
								return getSelection(this).end;
							}
							webshims.error(error);
						},
						set: function(v){
							if(this.createTextRange && (isTextarea || allowedTypes[$.prop(this, 'type')])){
								var range = this.createTextRange();
								var start;
								range.collapse(true);
								start = getSelection(this, true).start;
								range.moveStart('character', start);
								range.moveEnd('character', v - start);
								if($(this).is(':focus')){
									range.select();
								}
							} else {
								webshims.error(error);
							}
						}
					},
					setSelectionRange: {
						value: function(start, end, dir){
							if(this.createTextRange && (isTextarea || allowedTypes[$.prop(this, 'type')])){
								var range = this.createTextRange();
								range.collapse(true);
								range.moveStart('character', start);
								range.moveEnd('character', end - start);
								if($(this).is(':focus')){
									range.select();
								}
				