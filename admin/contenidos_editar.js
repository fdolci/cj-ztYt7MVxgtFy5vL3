    function arma_url_friendly(cual){
        var titulo = document.getElementById('xtitulo'+cual).value;
        url_amigable = titulo.toLowerCase();
        url_amigable = url_amigable.replace(/[ ]/gi,'-');
        url_amigable = url_amigable.replace(/[á]/gi,'a');
        url_amigable = url_amigable.replace(/[é]/gi,'e');
        url_amigable = url_amigable.replace(/[í]/gi,'i');
        url_amigable = url_amigable.replace(/[ó]/gi,'o');
        url_amigable = url_amigable.replace(/[ú]/gi,'u');
        url_amigable = url_amigable.replace(/[ñ]/gi,'n');
    /*    url_amigable = url_amigable.replace(/[/*()|&%$#"'!?¿\\/@{}°*+~]/gi,'-');                    */
        url_amigable1 = url_amigable.replace(/[----]/gi,'-');
        url_amigable2 = url_amigable1.replace(/[---]/gi,'-');
        url_amigable = url_amigable2.replace(/[--]/gi,'-');
        
        document.getElementById("url_amigable"+cual).value = url_amigable;
    /*    
        keyword      = url_amigable.replace(/[-]/gi,' ');
        document.getElementById("keywords"+cual).value = keyword;
    */    
    }

    function BrowseServer( startupPath, functionData ) {
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.basePath = '../';
        //Startup path in a form: "Type:/path/to/directory/"
        finder.startupPath = startupPath;
        // Name of a function which is called when a file is selected in CKFinder.
        finder.selectActionFunction = SetFileField;
        // Additional data to be passed to the selectActionFunction in a second argument.
        // We'll use this feature to pass the Id of a field that will be updated.
        finder.selectActionData = functionData;
        // Name of a function which is called when a thumbnail is selected in CKFinder.
        finder.selectThumbnailActionFunction = ShowThumbnails;
        // Launch CKFinder
        finder.popup();
    }

    // This is a sample function which is called when a file is selected in CKFinder.
    function SetFileField( fileUrl, data )  {
        document.getElementById( data["selectActionData"] ).value = fileUrl;
    }

    // This is a sample function which is called when a thumbnail is selected in CKFinder.
    function ShowThumbnails( fileUrl, data )  {
        // this = CKFinderAPI
        var sFileName = this.getSelectedFile().name;
        document.getElementById( 'thumbnails' ).innerHTML +=
                '<div class="thumb">' +
                    '<img src="' + fileUrl + '" />' +
                    '<div class="caption">' +
                        '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
                    '</div>' +
                '</div>';
        document.getElementById( 'preview' ).style.display = "";
        // It is not required to return any value.
        // When false is returned, CKFinder will not close automatically.
        return false;
    }



    function autoResize(){
        var newheight;
        var newwidth;
        document.getElementById('iframe1').height= "100px";
        if(document.getElementById){
            newheight=document.getElementById('iframe1').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('iframe1').height= (newheight) + "px";
    }



