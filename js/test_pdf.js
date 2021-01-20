$("#test").on('click', function() {
    console.log('export');
    
    var chart=$("#typologie").highcharts();
    var svgData = chart.getSVG();
    // Method 4: client-side-only solution (SVG -> Canvas -> PNG)
    // Problem: has a security error in Safari
    //var canvas = document.createElement('canvas');
    //canvas.width = svgData.width;
    //canvas.height = svgData.height;
    //var ctx = canvas.getContext('2d');
    var img = document.createElement('img');
    img.setAttribute('src', 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData))));
    
    $("#olaa").append(img);
    //img.onload = function() {
    //    ctx.drawImage(img, 100, 100);
    //    window.open(img);
    //};
    
});


// PHP copy file on serveur then use it in html2pdf
//$img_base64_encoded = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA0gA...';
//$imageContent = file_get_contents($img_base64_encoded);
//$path = tempnam(sys_get_temp_dir(), 'prefix');
//file_put_contents ($path, $imageContent);
//$img = '<img src="' . $path . '">';
//$pdf->writeHTML($img, true, false, true, false, '');