var CurrentPage = null;

/** Page Load **/
$(document).ready(function() {
    /** Load the menu and initial page **/
    loadMenu();
});

/** Loads the menu in the sidebar **/
function loadMenu() {
    GetPage('treemenu.html', 
        function(pResponse) {  
            $("#menu").jstree({
                "plugins" : [ "themes", "html_data",  "ui", "cookies"],
                "cookies" : {
                    "save_opened" : "evolved_tree",
                    "save_selected" : "evolved_selected",
                    "auto_save" : true
                },
                "themes" : {
                    "theme" : "apple",
                    "dots" : true,
                    "icons" : false
                },
                "html_data" : {
                    "data" : pResponse
                }
            });
            ShowLoading(false);
            AttachLinkEvents();
            
            var goTo = $.query.get('GoTo');
            if(goTo) {
                ShowPage(unescape(goTo));
            } else {
                GetPage('welcome.html', 
                    function(pResponse) {
                        $('#page').html(pResponse);
                        AttachLinkEvents();
                    }
                );
            }
        }
    );
}

/** Gets the content of a page **/
function GetPage(pUrl, pSuccessCallBack, pErrorCallBack){
    $.ajax({
            type: "POST",
            url: pUrl,
            dataType: 'html',
            async: true,
            error: function (){
                new pErrorCallBack();
            },
            success: function (response) {
                new pSuccessCallBack(response);
            }
        })
}

/** Puts the content of a page in the page div + rescan the page for the href's **/
function ShowPage(pUrl) {
    ShowLoading(true);
    GetPage(pUrl, 
        function(pResponse) {
            $('#page').html(pResponse);
            AttachLinkEvents();
            ShowLoading(false);
            CurrentPage = pUrl;
            var anchor = pUrl.hash;
            if(anchor) {
                document.location.hash = anchor;
            }
        }
    ,
        function() {
            ShowLoading(false); 
            alert('Error communicating with the server, please try again');
        }
    );
}

/** Attach the onclick events to all links that have rel=contents **/
function AttachLinkEvents() {
    var aElements = document.getElementsByTagName("a");
    for (i = 0; i < aElements.length; i++) {
        if (aElements[i].rel == "contents") {
            aElements[i].onclick = function() {
                var todomain = getDomain(this.href);
                var thisdomain = getDomain(window.location);
                if(todomain == thisdomain) {
                    ShowPage(this);
                    return false;
                } else {
                    window.open(this.href); return false;
                }
            }
        }
    }  
}

/** Opens a new window with the current state as url **/
function OpenNewWindow() {
    if(CurrentPage != null && window.location != CurrentPage) {
        window.open('?GoTo=' + escape(CurrentPage));
    } else {
        window.open('');
    }
    return false;
}

function ShowLoading(pShow) {
    if(pShow) {
        $('#loading').show();
        $('#loading-mask').show();        
    } else {
        $('#loading').hide();
        $('#loading-mask').hide();
    }
}

function getDomain(pUrl) {
    var url = new String(pUrl);
    return url.match(/:\/\/(www\.)?(.[^/:]+)/)[2];
}
