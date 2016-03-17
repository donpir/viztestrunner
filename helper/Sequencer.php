<?php

class Sequencer {

    /*static function exchange($arr, $counter) {
        $length = count($arr) < $counter ? count($arr) : $counter;
        $length = $counter % $length;

        for ($c=1; $c<$length; $c++) {
            $binary = decbin($c);
            $idxLast = strrpos($binary, '1');
            $idxFirst = strpos($binary, '1');

            $temp = $arr[$idxLast];
            $arr[$idxLast] = $arr[$idxFirst];
            $arr[$idxFirst] = $arr[$temp];
        }//EndFor.
    }//EndFunction.

    static $sequence = [ 2, 5, 2, 5, 2, 9, 2, 5, 2, 5, 2, 9 ];

    static function next($arr, $iteration) {
        $binary = decbin($iteration);
        $idxLast = strrpos($binary, '1');
        $idxFirst = strpos($binary, '1');
        echo "binary |" . $binary . " idxlast " . $idxLast . ", first " . $idxFirst . "<br>";
        $temp = $arr[$idxLast];
        $arr[$idxLast] = $arr[$idxFirst];
        $arr[$idxFirst] = $temp;

        return ++$iteration;
    }//EndFunction.

    static function arrToString($arr) {
        $length = count($arr);
        $str = "[";
        for ($i=0; $i<$length; $i++) {
            $str .= $arr[$i] . ( $i<$length-1 ? ', ' : '' );
        }
        $str .= "]";
        return $str;
    }//EndFunction

    static function nextSwap($arr, $iteration) {
        $binary = decbin($iteration);
        $idx = strlen($binary) - strpos($binary, '1');
        //$idx = strlen($binary) - strpos($binary, '1');
        //$idxLast = strrpos($binary, '1');
        //$idxFirst = strpos($binary, '1');
        $pow2 = pow(2, $idx-1);

        echo "iter " . $iteration . " binary |" . $binary . "| idx " . $idx . " pow " . $pow2 . "<br>";
        $swap = 0;
        if ($pow2 == 1) $pow2++;

        $newArr = Sequencer::swapOnOnes($arr, $pow2 + 1);
        $iteration = $iteration - $pow2;
        if ($iteration > 0)
            $newArr = Sequencer::nextSwap($newArr, $iteration);


        return $newArr;
    }//EndFunction.

    static function swap($arr, $iteration) {

        while ($iteration > 0) {
            $binary = decbin($iteration);
            $idx = strlen($binary) - strpos($binary, '1');
            //$idx = strlen($binary) - strpos($binary, '1');
            //$idxLast = strrpos($binary, '1');
            //$idxFirst = strpos($binary, '1');
            $pow2 = pow(2, $idx - 1);
            $swap = $pow2 + 1;

            if ($swap % 2 == 0) $swap += 1;



            echo "iter " . $iteration . " binary |" . $binary . "| idx " . $idx . " pow " . $pow2 . " swap: " . $swap . "<br>";

            $arr = Sequencer::swapOnOnes($arr, $swap);
            echo Sequencer::arrToString($arr) . "<br>";
            $iteration = $iteration - $pow2;
        }

        return $arr;
    }//EndFunction.

    static function swapOnOnes($arr, $n) {
        if ($n <= 0) return $arr;

        $binary = decbin($n);
        while (count($arr) - strlen($binary) > 0)
            $binary = "0" . $binary;


        //$idxLast = strlen($binary) - strrpos($binary, '1') + 1;
        //$idxFirst = strlen($binary) - strpos($binary, '1') + 1;
        $idxFirst = strpos($binary, '1');
        $idxLast = strrpos($binary, '1');

        //$idxFirst = count($arr) - $idxFirst + 1;
        //$idxLast = count($arr) - $idxLast  + 1;

        //if ($idxFirst == $idxFirst)
        //    $idxFirst--;

        echo "n=" . $n . "> binary |" . $binary. "| (len " . strlen($binary) . ") idxLast " . $idxLast . " idxFirst " . $idxFirst . "<br>";

        $temp = $arr[$idxLast];
        $arr[$idxLast] = $arr[$idxFirst];
        $arr[$idxFirst] = $temp;
        return $arr;
    }//EndFunction.

    static function swapper1($arr, $kth) {
        $n = count($arr);
        $nfact = Sequencer::fact($n);
        $kth = $kth % $nfact;
        echo "kth " . $kth . " => ";
        //echo "array size " . $n . "<br>";

        for ($i=$n; $i>=2; $i--) {
        //for ($i=2; $i<=$n; $i++) {
            $j = $kth % $i;

            //echo "kth " . $kth . " => i " . $i . " => j " . $j . "<br>";
            if ($j > 0) {
                $ii = $n - $i;
                $jj = $n - $j;

                //echo "kth " . $kth . " => i " . $ii . " => j " . $jj . " => ";


                $temp = $arr[$ii];
                $arr[$ii] = $arr[$jj];
                $arr[$jj] = $temp;
            }
        }//EndFor.

        return $arr;
    }//EndFunction.

    static function swapper($arr, $kth) {
        $n = count($arr);
        $nfact = Sequencer::fact($n);
        $kth = $kth % $nfact;
        //echo "kth " . $kth . " => ";
        //echo "array size " . $n . "<br>";

        for ($i=$n; $i>=2; $i--) {
            //for ($i=2; $i<=$n; $i++) {
            $j = $kth % $i;

            //echo "kth " . $kth . " => i " . $i . " => j " . $j . "<br>";
            $ii = $n - $i;
            $jj = $n - $j - 1;

            //echo "kth " . $kth . " => i " . $ii . " => j " . $jj . " => ";


            $temp = $arr[$ii];
            $arr[$ii] = $arr[$jj];
            $arr[$jj] = $temp;
        }//EndFor.

        return $arr;
    }//EndFunction.

    static function fact($n) {
        $fact = 1;
        for($i=$n; $i>0; $i--) {
            $fact = $i * $fact;
        }
        return $fact;
    }//EndFunction.*/

    static function nth_permutation($atoms, $index, $size) {
        for ($i = 0; $i < $size; $i++) {
            $item = $index % count($atoms);
            $index = floor($index / count($atoms));
            $result[] = $atoms[$item];
            array_splice($atoms, $item, 1);
        }
        return $result;
    }

}//EndClass.


/*$arr = [3, 2, 1];

for ($i=0; $i<12; $i++) {
    //print_r($arr);
    //$narr = Sequencer::swapper($arr, $i);
    $narr = Sequencer::nth_permutation($arr, $i, count($arr));
    //print_r($narr);
    echo Sequencer::arrToString($narr) . "<br>";
}*/


/*$n = count($arr);
$iteration = 8;
echo Sequencer::arrToString($arr) . "<br>";
$nArr = Sequencer::swap($arr, $iteration);
$iteration++;*/



//UNIT TESTING.
/*$iteration = 12;
$nArr = Sequencer::swapOnOnes($arr, $iteration);
echo Sequencer::arrToString($arr) . "<br>";
echo Sequencer::arrToString($nArr) . "<br>";
$iteration++;*/

