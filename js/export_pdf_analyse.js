function svgString2Image(svgString, width, height, format, callback) {
    // set default for format parameter
    format = format ? format : 'png';
    // SVG data URL from SVG string
    var svgData = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
    // create canvas in memory(not in DOM)
    var canvas = document.createElement('canvas');
    // get canvas context for drawing on canvas
    var context = canvas.getContext('2d');
    // set canvas size
    canvas.width = width;
    canvas.height = height;
    // create image in memory(not in DOM)
    var image = new Image();
    // later when image loads run this
    image.onload = function () { // async (happens later)
        // clear canvas
        context.clearRect(0, 0, width, height);
        // draw image with SVG data to canvas
        context.drawImage(image, 0, 0, width, height);
        // snapshot canvas as png
        var pngData = canvas.toDataURL('image/' + format);
        // pass png data URL to callback
        callback(pngData);
    }; // end async
    // start loading SVG data into in memory image
    image.src = svgData;
}




$("#test").on('click', function() {
    console.log('export');
    var chart=$("#typologie").highcharts();
    var svgData = chart.getSVG();
    var img = document.createElement('img');
    img.setAttribute('src', 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData))));
    $("#olaa").append(img);
});


// PHP copy file on serveur then use it in html2pdf
//$img_base64_encoded = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA0gA...';
//$imageContent = file_get_contents($img_base64_encoded);
//$path = tempnam(sys_get_temp_dir(), 'prefix');
//file_put_contents ($path, $imageContent);
//$img = '<img src="' . $path . '">';
//$pdf->writeHTML($img, true, false, true, false, '');

$("#analyse_pdf_export").on('click', function() {
    window.scrollTo(0, 0);
    change_load("Chargement de la fiche PDF...");
    var id_semi = "";
    
    //save graph typologie
    var chart=$("#typologie").highcharts();
    var svgDatatypologie = chart.getSVG();
    svgString2Image(svgDatatypologie, 800, 600, 'png', /* callback that gets png data URL passed to it */function (pngData) {
        // pngData is base64 png string
        $.ajax({
        url: 'php/ajax/analyse/graph/typologie.js.php',
        method   : "POST",
        dataType : "text",
        async    : false,
        data: {
            pngdata : pngData
        },
        success: function(data) {
            console.log('typologie.img');
        }
        });
    });
    
    //save graph atterrissement
    var chart=$("#atterrissement").highcharts();
    var svgDataatterrissement = chart.getSVG();
    svgString2Image(svgDataatterrissement, 800, 600, 'png', /* callback that gets png data URL passed to it */function (pngData) {
        // pngData is base64 png string
        $.ajax({
        url: 'php/ajax/analyse/graph/atterrissement.js.php',
        method   : "POST",
        dataType : "text",
        async    : false,
        data: {
            pngdata : pngData
        },
        success: function(data) {
            console.log('atterrissement.img');
        }
        });
    });
    //save graph usage
    var chart=$("#usage").highcharts();
    var svgDatausage = chart.getSVG();
    svgString2Image(svgDatausage, 800, 600, 'png', /* callback that gets png data URL passed to it */function (pngData) {
        // pngData is base64 png string
        $.ajax({
        url: 'php/ajax/analyse/graph/usage.js.php',
        method   : "POST",
        dataType : "text",
        async    : false,
        data: {
            pngdata : pngData
        },
        success: function(data) {
            console.log('usage.img');
        }
        });
    });
    //save graph alimentation
    var chart=$("#alimentation").highcharts();
    var svgDataalimentation = chart.getSVG();
    svgString2Image(svgDataalimentation, 800, 600, 'png', /* callback that gets png data URL passed to it */function (pngData) {
        // pngData is base64 png string
        $.ajax({
        url: 'php/ajax/analyse/graph/alimentation.js.php',
        method   : "POST",
        dataType : "text",
        async    : false,
        data: {
            pngdata : pngData
        },
        success: function(data) {
            console.log('alimentation.img');
        }
        });
    });
    //save graph contexte
    var chart=$("#contexte").highcharts();
    var svgDatacontexte = chart.getSVG();
    svgString2Image(svgDatacontexte, 800, 600, 'png', /* callback that gets png data URL passed to it */function (pngData) {
        // pngData is base64 png string
        $.ajax({
        url: 'php/ajax/analyse/graph/contexte.js.php',
        method   : "POST",
        dataType : "text",
        async    : false,
        data: {
            pngdata : pngData
        },
        success: function(data) {
            console.log('contexte.img');
        }
        });
    });
    
    
    //$.ajax({
    //    url: 'php/analyse_pdf.php',
    //    method   : "POST",
    //    dataType : "text",
    //    async    : false,
    //    data: {
    //        id_semi: id_semi
    //    },
    //    success: function() {
    //        //var blob=new Blob([data]);
    //        //var link=document.createElement('a');
    //        //link.href=window.URL.createObjectURL(blob);
    //        //link.download="fiche_mare.php";
    //        //link.click();
    //        //console.log("ended");
    //        
    //        //$myfile = fopen("temp.pdf", "w") or die("Unable to open file!");
    //        //$txt = "Mickey Mouse\n";
    //        //fwrite($myfile, $txt);
    //        //$txt = "Minnie Mouse\n";
    //        //fwrite($myfile, $txt);
    //        //fclose($myfile);
    //        
    //        //open file
    //        //window.location = 'pdf/fiche_mare.pdf';
    //        //window.open('localhost:82/pram_v4444/pdf/fiche_mare.pdf','_blank');
    //        window.open('pdf/fiche_mare.pdf');
            change_load();
    //    }
    //});
});
