<?php


namespace App;


class cyka
{
    public function getBabs(array $babsFromDp) {
        $end = 0;
        foreach ($babsFromDp as $babFromDp) {


            $lala = $babFromDp['cit222y']['id'];


            if ($lala == 650) {
                $end = $babFromDp;
                //dd($end);
            }

        }
        return $end;
    }
}
