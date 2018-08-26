<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Reader_Excel5
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt        LGPL
 * @version    1.8.0, 2014-03-02
 */


/**
 * PHPExcel_Reader_Excel5_MD5
 *
 * @category        PHPExcel
 * @package                PHPExcel_Reader_Excel5
 * @copyright        Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Reader_Excel5_MD5
{
    // Context
    private $a;
    private $b;
    private $c;
    private $d;


    /**
     * MD5 stream constructor
     */
    public function __construct()
    {
        $this->reset();
    }


    /**
     * Reset the MD5 stream context
     */
    public function reset()
    {
        $this->a = 0x67452301;
        $this->b = 0xEFCDAB89;
        $this->c = 0x98BADCFE;
        $this->d = 0x10325476;
    }


    /**
     * Get MD5 stream context
     * 
     * @return string
     */
    public function getContext()
    {
        $s = '';
        foreach (array('a', 'b', 'c', 'd') as $i) {
            $v = $this->{$i};
            $s .= chr($v & 0xff);
            $s .= chr(($v >> 8) & 0xff);
            $s .= chr(($v >> 16) & 0xff);
            $s .= chr(($v >> 24) & 0xff);
        }

        return $s;
    }


    /**
     * Add data to context
     * 
     * @param string $data Data to add
     */
    public function add($data)
    {
        $words = array_values(unpack('V16', $data));

        $A = $this->a;
        $B = $this->b;
        $C = $this->c;
        $D = $this->d;

        $F = array('PHPExcel_Reader_Excel5_MD5','F');
        $G = array('PHPExcel_Reader_Excel5_MD5','G');
        $H = array('PHPExcel_Reader_Excel5_MD5','H');
        $I = array('PHPExcel_Reader_Excel5_MD5','I');

        /* ROUND 1 */
        self::step($F, $A, $B, $C, $D, $words[0], 7, 0xd76aa478);
        self::step($F, $D, $A, $B, $C, $words[1], 12, 0xe8c7b756);
        self::step($F, $C, $D, $A, $B, $words[2], 17, 0x242070db);
        self::step($F, $B, $C, $D, $A, $words[3], 22, 0xc1bdceee);
        self::step($F, $A, $B, $C, $D, $words[4], 7, 0xf57c0faf);
        self::step($F, $D, $A, $B, $C, $words[5], 12, 0x4787c62a);
        self::step($F, $C, $D, $A, $B, $words[6], 17, 0xa8304613);
        self::step($F, $B, $C, $D, $A, $words[7], 22, 0xfd469501);
        self::step($F, $A, $B, $C, $D, $words[8], 7, 0x698098d8);
        self::step($F, $D, $A, $B, $C, $words[9], 12, 0x8b44f7af);
        self::step($F, $C, $D, $A, $B, $words[10], 17, 0xffff5bb1);
        self::step($F, $B, $C, $D, $A, $words[11], 22, 0x895cd7be);
        self::step($F, $A, $B, $C, $D, $words[12], 7, 0x6b901122);
        self::step($F, $D, $A, $B, $C, $words[13], 12, 0xfd987193);
        self::step($F, $C, $D, $A, $B, $words[14], 17, 0xa679438e);
        self::step($F, $B, $C, $D, $A, $words[15], 22, 0x49b40821);

        /* ROUND 2 */
        self::step($G, $A, $B, $C, $D, $words[1], 5, 0xf61e2562);
        self::step($G, $D, $A, $B, $C, $words[6], 9, 0xc040b340);
        self::step($G, $C, $D, $A, $B, $words[11], 14, 0x265e5a51);
        self::step($G, $B, $C, $D, $A, $words[0], 20, 0xe9b6c7aa);
        self::step($G, $A, $B, $C, $D, $words[5], 5, 0xd62f105d);
  