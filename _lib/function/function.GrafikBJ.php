<?php

//user define variable
//$Data=array(10,230,70,44,20,30,97,150,200,70,44,20,30,97,100,99,210,200,300);
//$NamaX=array("a","b","c","d","e","f","g","h","i","jas","Jantung","l","m","n","o","p","q","r","s","t");
//GrafikBatang($Data, $NamaX);

function GrafikBJ($BOR, $ALOS, $TOI, $BTO, $Tahun)
{
	$jum_data=count($Data);
	//$temp=arsort($Data);
	//Setting Variable
	$max=0;
	for($i=0;$i<$jum_data;$i++)
	{
		if($Data[$i]>$max)
			$max=$Data[$i];
	}
	$kiri=40;
	$jedaBawah=40;
	$tinggi=550;
	$lebar=425;
	$kanan=20;
	$atas=20;

	//Pre process data
	$tinggiImage=$jedaBawah+$tinggi+$atas;
	$lebarImage=$kiri + $lebar+$kanan;
	$bawah=$tinggiImage-$jedaBawah;
	$jum_skalay=10;

	//echo $lebar;
	//Inisialisasi Image
	//header ("Content-type: image/png");
	$im = ImageCreate ($lebarImage, $tinggiImage);
	$background_color = ImageColorAllocate ($im, 255, 255, 255);

	//Set Warna
	$hijau=ImageColorAllocate ($im, 115, 255, 89);
	$hijau2=ImageColorAllocate ($im, 202, 255, 202);
	$hijau3=ImageColorAllocate ($im, 98, 217, 76);
	$hitam=ImageColorAllocate ($im, 0, 0, 0);
	$abuabu=ImageColorAllocate ($im, 200, 200, 200);
	$merah = ImageColorAllocate ($im, 255, 0, 0);
	$putih=ImageColorAllocate ($im, 255,255,255);
	$biru=ImageColorAllocate ($im, 0,0,255);

	//Set Line
	imagesetthickness($im, 2);
	//imageline($im, $kiri, 0, $kiri, $bawah, $hitam);
	//imageline($im, $kiri, $bawah, $lebar+$kiri, $bawah, $hitam);
	imagerectangle ($im, $kiri, 2+$atas, $lebar+$kiri, $bawah, $hitam);
	//imagefill($im,$kiri+4,$atas+10, $hijau2);


	//buat legend skala pada sumbu garis
	//Sumbu y - vertikal
	$max=15;
	$digit=pow(10,(strlen($max)-1));
	//$max=(ceil($max/$digit))*$digit;
	//if($max==0) $max=1;
	$skalaY=1;//$max/10;
	$jeda=$tinggi/16;
	for($i=0; $i<16; $i++)
	{	
		$y=$atas+(($i+1)*$jeda);
		imageline($im, $kiri-5, $y, $kiri, $y, $hitam);
		imagesetthickness($im, 1);
		//imageLine($im, $kiri+1, $y, $lebarImage-2, $y, $abuabu);
		imagesetthickness($im, 2);
		ImageString ($im, 2,$kiri-40, $y-5, "" . $max-($i*$skalaY), $hitam);
	}

	//Sumbu x - horizontal
	$jum_data=10;
	$skalaX=floor($lebar/$jum_data);
	$flag=0;
	for($i=1,$j=1; $i<=$jum_data; $i++)
	{
		$x=$i*$skalaX;
		imageline($im, $kiri+$x, $bawah, $kiri+$x, $bawah+5, $hitam);
		if($flag==1)
		{
			ImageString ($im, 2,$kiri+$x-6, $bawah+10, "" . $j, $hitam);			
			$j++;
			$flag=0;
		}
		else
			$flag=1;
		//print string legenda di titik X
	}

	//Membuat Daerah Efesiensi
	$ArrPoly[0]=$kiri+($skalaX*2);
	$ArrPoly[1]=4+$atas;
	$ArrPoly[2]=$kiri+($skalaX*6);
	$ArrPoly[3]=4+$atas;
	$ArrPoly[4]=$kiri+($skalaX*6);
	$ArrPoly[5]=$bawah-($skalaX*6*tan(M_PI/4));
	$ArrPoly[6]=$kiri+($skalaX*2);
	$ArrPoly[7]=$bawah-($skalaX*2*tan(M_PI/4));
	$THuruf=20*6;
	imagefilledpolygon($im,$ArrPoly, count($ArrPoly)/2, $hijau2);
	imagestringup($im, 20,$kiri+($skalaX*4)-4,$atas+$THuruf+($jeda*4),"Daerah Yang Efisien",$hitam);

	//Membuat garis BOR
	$teta=(M_PI/2)/5;
	$temp=cos($teta);
	$ArrBOR=array(50,70,80,90);
	for($i=0; $i<4; $i++)
	{
		$y=tan($teta)*$lebar;
		if($y>$lebar)
		{
			$y=$tinggi/tan($teta);
			imageline($im, $kiri, $bawah, $y+$kiri, $atas+2, $hitam);
			imageString($im, 2,$y+$kiri, 6, "" . $ArrBOR[$i] . "%", $hitam);
		}else{
			imageline($im, $kiri, $bawah, $lebar+$kiri, $bawah-$y, $hitam);
			imageString($im, 2, $lebar+$kiri+2, $bawah-$y, $ArrBOR[$i] . "%", $hitam);
		}
		//ImageString ($im, 2,$lebar/2+$kiri, $bawah-(tan($teta)*($lebar/15))+20, "" . $i+1, $hitam);
		$teta+=(M_PI/10);
	}

	//Set Titik dengan format sbb: [BOR, LOS, TOI, BTO]
	for($i=0; $i<count($Tahun); $i++)
	{
		//Mapping titik TOI
		$x=$TOI[$i]*($skalaX*2);
		$x+=$kiri;
		//Mapping titik ALOS
		$y=$bawah-($ALOS[$i]*$jeda);

		//Mapping titik BOR
		$teta=$BOR[$i];
		if($teta<50)
		{
			$oneDeg=90/250;
			$teta=$teta*$oneDeg;
		}
		elseif($teta<70)
		{
			$oneDeg=90/350;
			$teta=$teta*$oneDeg;
		}		
		elseif($teta<80)
		{
			$oneDeg=90/400;
			$teta=$teta*$oneDeg;
		}
		elseif($teta<90)
		{
			$oneDeg=90/450;
			$teta=$teta*$oneDeg;
		}
		else
		{
			$oneDeg=90/500;
			$teta=$teta*$oneDeg;	
		}
		//Mapping titik yang sebenarnya
		$titikX[$i]=$x;
		$titikY[$i]=$y;
		imagesetthickness($im, 5);	
		if($i>0)
			imageline($im, $titikX[$i-1],$titikY[$i-1], $titikX[$i],$titikY[$i],$merah);			
		imagesetthickness($im, 1);
		$style=array($hitam,$hitam,$hitam,$hitam,$hitam,$hijau2,$hijau2,$hijau2,$hijau2,$hijau2);
		ImageSetStyle($im, $style);
		ImageLine($im, $kiri, $y, $x, $y, IMG_COLOR_STYLED);
		//imagedashedline ($im, $kiri, $y, $x,$y, $hitam);
		imagedashedline ($im,$x,$y,$x,$bawah-2, $hitam);
		imagesetthickness($im, 2);
		//imagefilledarc ($im, $x, $y, 10, 10, 0, 360, $hijau3, IMG_ARC_PIE);
		imageString($im, 2, $x-25,$y-20,$Tahun[$i],$hitam);
	}
	
	//Membuat grafik tampilan untuk titik
	for($i=0; $i<count($Tahun); $i++)
	{
		imagefilledarc($im, $titikX[$i], $titikY[$i], 10, 10, 0, 360, $hijau3, IMG_ARC_PIE);
		imagearc($im, $titikX[$i], $titikY[$i], 10, 10, 0, 360, $hitam);
	}

	//Batang
	//$skalaX=floor($lebarImage/$jum_data);

	ImagePng ($im,"gb3.png");
	//ImagePng ($im);
	ImageDestroy($im);
}

//masukan GarifkBJ([BOR],[ALOS],[TOI],[BTO],[Tahun]);
//GrafikBJ(array(60,70,40,30,55),array(5.5,6,6.3,7,4),array(3.4,3.6,4.4,3.9,4.9),array(10,20,30,40,50),array("1997","1998","1999","2000","2001"));
?>
