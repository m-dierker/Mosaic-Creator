
initListeners();
setActiveStep('fileUploadStep');

// Initialize any listeners that need to be initialized
function initListeners()
{
	$(".sidebarStep").hover(function()
	{
		var id = $(this).attr('id');
		fadeInActiveStep(id);

	}, function(){

		var id = $(this).attr('id');
		fadeOutActiveStep(id);
	});

	$(".sidebarStep").click(function()
	{
		setActiveStep($(this).attr('id'));
	});
}

// Sets the active step (as it was clicked)
function setActiveStep(id)
{
	if(activeStep !== null)
	{
		$('#' + activeStep + " .stepSelector").hide("slide", { direction: "right" }, 100);
	}

	activeStep = id;

	$('#' + activeStep + " .stepSelector").show("slide", { direction: "left" }, 100)


	switch(activeStep)
	{
		case 'fileUploadStep':
			hideOtherSteps('fileUpload');
			$('#fileUpload').slideDown();
			break;

		case 'selectSourceStep':
			hideOtherSteps('selectSource');
			$('#selectSource').slideDown();
			break;

		case 'formatImagesStep':
			hideOtherSteps('formatImages');
			$('#formatImages').slideDown();
			break;
	}
}

// Hides other steps besides the specified one
function hideOtherSteps(id)
{
	if(typeof id === undefined)
		$('.step').slideUp();
	else
		$('.step').not('#' + id).slideUp();

}

// Fade in the active step for the steps menu
function fadeInActiveStep(id)
{ 
	$('#'+id).animate(
		{
			backgroundColor: "#FFF79F"
		}, 25);
}

function fadeOutActiveStep(id)
{
	$('#'+id).animate(
		{
			backgroundColor: "#EEEEEE"
		}, 100);
}

// Called when the Facebook Javascript (FB.init()) is finished loading
function facebookInitComplete()
{
	setupFacebook();
    checkFacebookLogin();
}

// Sets up the facebook listeners for login/logout
function setupFacebook()
{
	FB.Event.subscribe('auth.login', function(response) {
        onUserLogin();
	});

	FB.Event.subscribe('auth.logout', function(response) {
		onUserLogout();
	});
}

// Called after the user has logged in via Facebook
function onUserLogin()
{
    console.log("We're in onUserLogin");
    
    setUserFacebookName();
    
    setupFileUpload();

    showOnLoginItems();
}

// Called after the user has logged out via Facebook
function onUserLogout()
{
    console.log("We're in onUserLogout");
    
    showOnLogoutItems();
}

// Check if facebook is logged in, and do the appropriate actions
function checkFacebookLogin()
{
	// Get the facebook login status
	FB.getLoginStatus(function(response) {

		if(response.status === 'connected')
		{
            console.log("Facebook says we're logged in and authenticated");
			// The user is logged in, and has authenticated the app
            onUserLogin();
		}
		else if(response.status === 'not_authorized')
		{   
            console.log("Facebook says we're logged in but not authorized for the app");
            // The user is logged into Facebook, but not authorized for the app
			onUserLogout();
		}
		else
		{
            console.log("Facebook says we aren't logged in");
            // The user is logged out
			onUserLogout();
        }

	});
}

// Called when the user clicks logout
function logout()
{
	FB.logout();
    $.get('logout.php');
}

// Shows login items
function showOnLogoutItems()
{
    $('.onLogoutSlideOut').hide(750);
    $('.onLogoutSlideIn, .onLogoutSlide').slideDown(750);
    $('.onLogoutFadeIn, .onLogoutFade').fadeIn(750);
    $('.onLogoutFadeOut').fadeOut(750);
    $('.onLogoutShow').show(0);
    $('.onLogoutHide').hide(0);
    
    $('.onLoginSlide').hide(0);
    $('.onLoginFade').fadeOut(750);

}

// Shows login items
function showOnLoginItems()
{
    $('.onLoginSlideOut').hide(750);
    $('.onLoginSlideIn, .onLoginSlide').slideDown(750);
    $('.onLoginFadeIn, .onLoginFade').fadeIn(750);
    $('.onLoginFadeOut').fadeOut(750);
    $('.onLoginShow').show(0);
    $('.onLoginHide').hide(0);
    
    $('.onLogoutSlide').hide(0);
    $('.onLogoutFade').fadeOut(750);

}

// Sets the facebook names up on the page
function setUserFacebookName()
{
    console.log("Setting up facebook names");
	FB.api('/me', function (response){
		setFacebookName(response.name);
		setFacebookFirstName(response.first_name);
		setFacebookLastName(response.last_name);
		facebookID = response.id;
		setFacebookLinks(response.link);
	});
}

// Makes the profile links link to the user's profile
function setFacebookLinks(link)
{
	$('a.fb-profile-link').attr('href', link);
}

// Sets the user's facebook first name
function setFacebookFirstName(name)
{
	facebookFirstName = name;
	$('.fb-first-name').text(facebookFirstName);
}

// Sets the user's facebook last name
function setFacebookLastName(name)
{
	facebookLastName = name;
	$('.fb-last-name').text(facebookLastName);
}

// Sets the user's facebook name
function setFacebookName(name)
{
	facebookName = name;
	$('.fb-name').text(facebookName);
}
