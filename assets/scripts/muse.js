/* 
 * This javascript file is necessary for the functioning of the theme
 */

$(document).ready(function(){ 
        $("ul.sf-menu").superfish(); // Superfish Menus!

        $(".sortable").sortable({ // Makes a list sortable
            revert: true
        });

        $("#loginarrow").click(function() {
            $("#logindrop").toggle("slow");
            return false;
        });
		
		$("#loginarrow").blur(function() {
            $("#logindrop").delay(500).hide("slow");
            return false;
        });

        $("#settings").click(function() {
            $("#settingsdrop").toggle("slow");
            return false;
        });
		
		$("#settings").blur(function() {
            $("#settingsdrop").delay(500).hide("slow");
            return false;
        });

		$("#search").click(function() {
            $("#searchdrop").toggle("slow");
            return false;
        });	// */
        
        $(".notification").click(function() {
            $(this).fadeOut("slow");
        });
        
});