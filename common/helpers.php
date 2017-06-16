<?php
/**
 * Created by Topalek
 * Date: 16.06.2017
 * Time: 11:33
 */

function dump($data,$die=1)
{
	$num = 10; $highlight = true;
	yii\helpers\VarDumper::dump($data, $num, $highlight);
	if ($die){
		die;
	}
}