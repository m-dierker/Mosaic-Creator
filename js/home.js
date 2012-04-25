// Initialize the various steps, and their associated divs to be shown/hidden.
// These should be in the order they appear for right/left sliding to work properly
var stepList = ['fileUploadStep', 'selectSourceStep', 'createMosaicStep'];
var stepDivs = ['fileUpload', 'selectSource', 'createMosaic']; 


var facebookName, facebookFirstName, facebookLastName, facebookID;
var activeStep = null;
var sourceImage = null;
var sourceGallerySetup = false;
var imageList = null;
var processedCount, imageCount;

initListeners();
setActiveStep('fileUploadStep');


// Initialize any listeners that need to be initialized
function initListeners()
{
	$(".sidebarStep").hover(function()
	{
		var id = $(this).attr('id');
		fadeInActiveStepLabel(id);

	}, function(){

		var id = $(this).attr('id');
		fadeOutActiveStepLabel(id);
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
		if(id == activeStep)
			return;

		$('#' + activeStep + " .stepSelector").hide("slide", { direction: "right" }, 100);
	}

	// Slides the selector in for the new element
	$('#' + id + " .stepSelector").show("slide", { direction: "left" }, 100)

	// Slides the current step out in the correct direction
	var slideRight =stepList.indexOf(activeStep) > stepList.indexOf(id);
	slideActiveStepOut(slideRight);

	// Slides the new step in
	slideNewStepIn(stepDivs[stepList.indexOf(id)], slideRight);

	activeStep = id;

	switch(activeStep)
	{
		case 'selectSourceStep':
			setupSelectSourceGallery();
			break;
		case 'createMosaicStep':
			setupCreateMosaic();
			break;
	}
}

// Requires a source image has been selected, or shows the error
// Returns true if there is a source image
function requireSourceImage()
{
	if(sourceImage === null)
	{
		$('#createMosaicNeedsSourceImage').slideDown();
		return false;
	}

	$('#createMosaicNeedsSourceImage').slideUp().hide();
		

	return true;
}

function formatImages(gallery)
{
	// If we don't have a source image, this will show the error and return
	if(!requireSourceImage())
		return;

	// Request the gallery and have it call this method again
	if(typeof gallery === 'undefined')
	{
		getImageList(function(data)
			{
				formatImages(data);
			});
		return;
	}

	processedCount = 0;
	imageCount = gallery.length - 1;

	$('#formatImagesStart').slideUp();
	$('#formatImagesComplete').slideUp();
	$('#formatImagesStatus').slideDown();

	for(index in gallery)
	{
		var img = gallery[index];

		var img_name = img['name'];

		if(img_name == sourceImage)
			continue;

		$.get('img_process.php?cmd=square&name=' + encodeURI(img_name), function(data)
		{
			if(data === "1")
			{
				imageProcessed(img_name);
			}
			else
				console.log("Error Processing Image " + img_name + ": " + data);

		});
	}
}

// Increments the progress bar and marks the image as procesesd
function imageProcessed(img_name)
{
	processedCount++;

	$('#formatImagesProgressBar').css('width', (processedCount/imageCount * 100.0) + '%');
	$('#formatImagesProgressStatus').text(processedCount + " / " + imageCount);

	// We're done, hiding the status div
	if(processedCount == imageCount)
	{
		$('#formatImagesStatus').slideUp();
		$('#formatImagesComplete').slideDown();

		createMosaic();
	}
}

// Actually creates the mosaic after the images have all been processed
function createMosaic()
{
	// Although there should be a source image, return anyways if there isn't.
	if(!requireSourceImage())
		return;

	console.log("Creating the mosaic!");

	$.get("make_mosaic.php?source=" + encodeURI(sourceImage), function(data)
		{
			mosaicCreationComplete();
		});
}

// Sets up formatting the images
function setupCreateMosaic()
{
	requireSourceImage();
}

// Sets up the select source gallery
function setupSelectSourceGallery(gallery)
{
	if(sourceGallerySetup)
		return;

	// Request the image gallery, or get the cached one if it exists
	if(typeof gallery === 'undefined')
	{
		getImageList(function(data)
			{
				setupSelectSourceGallery(data);
			});
		return;
	}

	var galleryWidth = 5;
	var galleryCount = 0;

	var text = '<table class="selectSourceGalleryTable">';

	for(index in gallery)
	{
		if(galleryCount % galleryWidth == 0)
		{
			text += '<tr>';
		}

		var img = gallery[index];
		text += '<td class="selectSourceImage" id="' + img['name'] + '"><img src="' + img['thumbnail_url'] + '" alt="' + img['name'] + '" title="' + img['name'] + '"><br><p alt="' + img['name'] + '" title="' + img['name'] + '">' + getNameForGallery(img['name']) + '</p></td>'

		galleryCount++;

		if(galleryCount % galleryWidth == 0)
		{
			text += '</tr>';
		}

	}	

	text += "</table>";

	$('#selectSourceGallery').html(text);

	$('td.selectSourceImage').hover(function()
	{
		// The image is being hovered over

		if($(this).attr('id') !== sourceImage)
			$(this).css("background-color", "#FFF79F");

	}, function()
	{
		// No more hover
		if($(this).attr('id') !== sourceImage)
			$(this).animate({

				backgroundColor: '#FFFFFF'

			}, 100);

	});

	$('td.selectSourceImage').click(function()
	{
		if(sourceImage !== null)
			clearSourceImageBackground();
		setSourceImage($(this).attr('id'));
	});

	sourceGallerySetup = true;
}

// Gets the image gallery, and calls the given callback
function getImageList(callback)
{
	if(imageList !== null)
	{
		callback(imageList);
		return;
	}

	$.get('upload-plugin/server/', function(gallery)
	{
		imageList = gallery;
		callback(imageList);
	});
}

// Clears the old source image's background
function clearSourceImageBackground()
{
	$('#' + sourceImage.replace('.', '\\.')).animate(
	{
		backgroundColor: "#FFFFFF"
	}, 100);
}

// Sets the source image
function setSourceImage(id)
{
	sourceImage = id;

	$('#' + sourceImage.replace('.', '\\.')).css('background-color', '#ffb980');
}

// Gets the name for the gallery
function getNameForGallery(name)
{
	if(name.length > 15)
		return name.substring(0, 12) + "...";

	return name;
}

// Slides the active step out to the left, and delays until it's done
function slideActiveStepOut(right)
{
	$('#' + stepDivs[stepList.indexOf(activeStep)]).hide("slide", {direction: (right? "right" : "left") }, 400);
}

// Slides the new step in, and sets the active step
function slideNewStepIn(id, right)
{
	$('#' + id).delay(400).show("slide", {direction: (right? "left" : "right")}, 400);
}

// Fade in the active step for the steps menu
function fadeInActiveStepLabel(id)
{ 
	$('#'+id).animate(
		{
			backgroundColor: "#FFF79F"
		}, 25);
}

function fadeOutActiveStepLabel(id)
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
