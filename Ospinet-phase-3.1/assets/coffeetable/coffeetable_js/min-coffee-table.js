function getCoffeeTableBrowserName() {
	try {
		if (navigator.userAgent.indexOf("MSIE") !== -1)
			return "Internet Explorer";
		else if (navigator.userAgent.indexOf("OPR") !== -1)
			return "Opera";
		else if (navigator.userAgent.indexOf("Opera") !== -1)
			return "Opera";
		else if (navigator.userAgent.indexOf("Firefox") !== -1)
			return "Firefox";
		else if (navigator.userAgent.indexOf("Chrome") !== -1)
			return "Chrome";
		return null
	} catch (e) {
		coffeeTable.error.code = "VC100";
		coffeeTable.error.detailedMessage = e;
		logError("getCoffeeTableBrowserName", coffeeTable.error);
		return false
	}
}
function getCoffeeTableBrowserVersion() {
	try {
		var e;
		if ((e = navigator.userAgent.indexOf("MSIE")) !== -1)
			return navigator.userAgent.substring(e + 4, e + 6);
		else if ((e = navigator.userAgent.indexOf("OPR")) !== -1)
			return navigator.userAgent.substring(e + 4, e + 6);
		else if ((e = navigator.userAgent.indexOf("Opera")) !== -1)
			return navigator.userAgent.substring(e + 4, e + 6);
		else if ((e = navigator.userAgent.indexOf("Firefox")) !== -1)
			return navigator.userAgent.substring(e + 8, e + 10);
		else if ((e = navigator.userAgent.indexOf("Chrome")) !== -1)
			return navigator.userAgent.substring(e + 7, e + 9);
		return null
	} catch (t) {
		coffeeTable.error.code = "VC100";
		coffeeTable.error.detailedMessage = t;
		logError("getCoffeeTableBrowserVersion", coffeeTable.error);
		return false
	}
}
function checkBrowserSupport() {
	try {
		switch (coffeeTable.browserName) {
		case "Chrome":
			if (coffeeTable.browserVersion < 24)
				throw 'Please upgrade to <a href="https://www.google.com/intl/en/chrome/browser/">Chrome version 24.0 or higher</a>.';
			break;
		case "Internet Explorer":
			return false;
			break;
		case "Firefox":
			if (coffeeTable.browserVersion < 22)
				throw 'Please upgrade to <a href="http://www.mozilla.org/en-US/">Firefox version 22.0 or higher</a>';
			break;
		case "Opera":
			if (navigator.appVersion.indexOf("Linux") === -1
					&& coffeeTable.browserVersion < 22)
				throw 'Please upgrade to <a href="http://www.opera.com/">Opera version 22.0 or higher</a>';
			else if (navigator.appVersion.indexOf("Linux") !== -1)
				throw 'Your linux Opera browser does not support Video Calling. Please switch to <a href="http://www.opera.com/">Opera for Windows version 22.0 or higher.</a>';
			break;
		default:
			throw 'Your web browser does not support Video Calling. Please switch to <a href="https://www.google.com/intl/en/chrome/browser/">Chrome version 24.0 or higher</a>, <a href="http://www.mozilla.org/en-US/">Firefox version 22.0 or higher</a> or <a href="http://www.opera.com/">Opera version 22.0 or higher</a>'
		}
		return true
	} catch (e) {
		coffeeTable.isError = true;
		coffeeTable.error.code = "VC100";
		coffeeTable.error.detailedMessage = e;
		logError("checkBrowserSupport", coffeeTable.error);
		return false
	}
}
function attachTipsy() {
	mrAudioMuteButton.tipsy({
		gravity : "s"
	});
	mrVideoMuteButton.tipsy({
		gravity : "s"
	});
	mrLowBandwidthButton.tipsy({
		gravity : "s"
	});
	mrEndButton.tipsy({
		gravity : "s"
	})
}
function getWebSocketURL() {
	try {
		var e = location.protocol;
		if (e.trim() === "http:") {
			return "ws://www.thecoffeetable.in:9000/bo/socket.bo.php"
		} else if (e.trim() === "https:") {
			return "wss://www.thecoffeetable.in:9443/bo/socket.bo.php"
		}
	} catch (t) {
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = t;
		logError("getWebSocketURL", coffeeTable.error);
		return false
	}
}
function initCoffeeTableComponents(e, t) {
	try {
		coffeeTable.customerId = $.trim(e);
		coffeeTable.appId = $.trim(t);
		coffeeTable.browserName = getCoffeeTableBrowserName();
		coffeeTable.browserVersion = getCoffeeTableBrowserVersion();
		coffeeTable.isReady = false;
		if (undefined === coffeeTable.isInitializing)
			coffeeTable.isInitializing = true;
		coffeeTable.isCreateMeetingSocket = false;
		coffeeTable.isError = false;
		coffeeTable.bandwidth = "default";
		coffeeTable.dailing = false;
		coffeeTable.waitingForParticipants = false;
		coffeeTable.onCall = false;
		coffeeTable.meetingStarted = false;
		coffeeTable.meetingEnded = false;
		coffeeTable.initiator = false;
		coffeeTable.screenSharing = false;
		coffeeTable.options = {
			optional : [ {
				DtlsSrtpKeyAgreement : true
			} ]
		};
		coffeeTable.socket = new Object;
		coffeeTable.socket.url = getWebSocketURL();
		coffeeTable.socket.conn = null;
		coffeeTable.trackers = new Object;
		coffeeTable.trackers.heartBeat = null;
		coffeeTable.trackers.serverHeartBeat = null;
		coffeeTable.trackers.reconnectionTimeOut = 3e4;
		coffeeTable.trackers.timeout = null;
		coffeeTable.trackers.highlightTimeOut = null;
		coffeeTable.trackers.initiatorOfflineTimeOut = null;
		coffeeTable.lastHeartbeatTime = null;
		coffeeTable.user = new Object;
		coffeeTable.user.id = null;
		coffeeTable.user.email = null;
		coffeeTable.user.name = null;
		coffeeTable.user.type = null;
		coffeeTable.user.authenticationName = null;
		coffeeTable.user.authenticationPassword = null;
		coffeeTable.user.verificationCode = null;
		coffeeTable.user.videoStream = null;
		coffeeTable.user.videoElement = null;
		coffeeTable.user.audioMuted = null;
		coffeeTable.user.videoMuted = null;
		coffeeTable.user.type = null;
		coffeeTable.peer = new Object;
		coffeeTable.peer.id = null;
		coffeeTable.peer.name = null;
		coffeeTable.peer.emailId = null;
		coffeeTable.participants = [];
		coffeeTable.meeting = new Object;
		coffeeTable.meeting.id = null;
		coffeeTable.meeting.participantCount = 0;
		coffeeTable.meeting.topic = "";
		coffeeTable.meeting.meetingMessage = "";
		coffeeTable.meeting.participants = [];
		coffeeTable.stats = new Object;
		coffeeTable.stats.bytesReceivedPrevious = 0;
		coffeeTable.stats.bytesReceivedNow = 0;
		coffeeTable.stats.bitRate = 0;
		coffeeTable.stats.highThresholdCounter = 0;
		coffeeTable.stats.lowThresholdCounter = 0;
		coffeeTable.serverParameters = new Object;
		coffeeTable.document = new Object;
		coffeeTable.document.originalTitle = null;
		coffeeTable.document.newTitle = null;
		coffeeTable.document.isTitleOriginal = false;
		return true
	} catch (n) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = n;
		logError("initCoffeeTableComponents", coffeeTable.error);
		return false
	}
}
function initMessageBoxElements() {
	try {
		ctNotification = $("#ctNotification");
		ctMessageBox = $("#ctMessageBox");
		ctMessageBoxTitle = $("#ctMessageBoxTitle");
		ctMessageBoxClose = $("#ctMessageBoxClose");
		ctMessageBoxInfo = $("#ctMessageBoxInfo");
		ctMessageBoxMainTextContainer = $("#ctMessageBoxMainTextContainer");
		ctMessageBoxImageContainer = $("#ctMessageBoxImageContainer");
		ctMessageBoxSuccessImage = $("#ctMessageBoxSuccessImage");
		ctMessageBoxLoaderImage = $("#ctMessageBoxLoaderImage");
		ctMessageBoxUserImage = $("#ctMessageBoxUserImage");
		ctMessageBoxMainText = $("#ctMessageBoxMainText");
		ctMessageBoxDetails = $("#ctMessageBoxDetails");
		ctMessageBoxDetailsPoints = $("#ctMessageBoxDetailsPoints");
		ctMessageBoxSolutionPoints = $("#ctMessageBoxSolutionPoints");
		ctAunthentication = $("#ctAunthentication");
		ctAddParticipantsSelectBox = $("#ctAddParticipantsSelectBox");
		ctTextBox = $("#ctTextBox");
		ctVerificationCode = $("#ctVerificationCodeTextBox");
		ctAddParticpants = $("#ctAddParticpants");
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++) {
			ctParticipants[counter] = $("#ctParticipant" + counter)
		}
		ctTopic = $("#ctTopic");
		ctUsername = $("#ctUsername");
		ctPassword = $("#ctPassword");
		ctMessageBoxCreateMeetingOptions = $("#ctMessageBoxCreateMeetingOptions");
		ctMessageBoxAddMessage = $("#ctMessageBoxAddMessage");
		ctMessageBoxMeetingMessage = $("#ctMessageBoxMeetingMessage");
		ctMessageBoxButtons = $("#ctMessageBoxButtons");
		ctMessageBoxButton1 = $("#ctMessageBoxButton1");
		ctMessageBoxButton2 = $("#ctMessageBoxButton2");
		if (!ctNotification.length)
			throw "Notification element not defined.";
		if (!ctMessageBox.length)
			throw "Message Box not defined.";
		if (!ctMessageBoxTitle.length)
			throw "Message Box Title not defined.";
		if (!ctMessageBoxClose.length)
			throw "Message Box Close Button not defined.";
		if (!ctMessageBoxInfo.length)
			throw "Message Box Info not defined.";
		if (!ctMessageBoxMainTextContainer.length)
			throw "Message Box text container not defined.";
		if (!ctMessageBoxImageContainer.length)
			throw "Message Box image container not defined.";
		if (!ctMessageBoxLoaderImage.length)
			throw "Message Box loader image not defined.";
		if (!ctMessageBoxUserImage.length)
			throw "Message Box user image not defined.";
		if (!ctMessageBoxSuccessImage.length)
			throw "Message Box success image not defined.";
		if (!ctMessageBoxMainText.length)
			throw "Message Box main text not defined.";
		if (!ctMessageBoxDetails.length)
			throw "Message Box details not defined.";
		if (!ctMessageBoxDetailsPoints.length)
			throw "Message Box detail points not defined.";
		if (!ctMessageBoxSolutionPoints.length)
			throw "Message Box solution not defined.";
		if (!ctAunthentication.length)
			throw "Message Box authentication not defined.";
		if (!ctAddParticipantsSelectBox.length)
			throw "Message Box selection box not defined.";
		if (!ctTextBox.length)
			throw "Message Box text box not defined.";
		if (!ctVerificationCode.length)
			throw "Message Box verification code not defined.";
		if (!ctAddParticpants.length)
			throw "Message Box participants not defined.";
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++) {
			if (!ctParticipants[counter].length)
				throw "Message Box not participant " + counter + " defined."
		}
		if (!ctTopic.length)
			throw "Message Box topic not defined.";
		if (!ctUsername.length)
			throw "Message Box username not defined.";
		if (!ctPassword.length)
			throw "Message Box password not defined.";
		if (!ctMessageBoxCreateMeetingOptions.length)
			throw "Message Box Create meeting options containter password not defined.";
		if (!ctMessageBoxAddMessage.length)
			throw "Message Box add message link not defined.";
		if (!ctMessageBoxMeetingMessage.length)
			throw "Message Box Meeting Message element not defined.";
		if (!ctMessageBoxButtons.length)
			throw "Message Box  Buttons not defined.";
		if (!ctMessageBoxButton1.length)
			throw "Message Box button 1 not defined.";
		if (!ctMessageBoxButton2.length)
			throw "Message Box button 2 not defined.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("initMessageBoxElements", coffeeTable.error);
		return false
	}
}
function initDockElements() {
	try {
		ctDock = $("#ctDock");
		ctDockMaximize = $("#ctDockMaximize");
		ctDockClose = $("#ctDockClose");
		if (!ctDock.length || !ctDockMaximize.length || !ctDockClose.length)
			throw "Dock else elements not defined.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("initDockElements", coffeeTable.error);
		return false
	}
}
function initMeetingRoomElements() {
	try {
		ctRingTone = $("#ctRingTone");
		ctDisconnectTone = $("#ctDisconnectTone");
		instantCallAddParticipant = $("#instantCallAddParticipant");
		meetingRoom = $("#meetingRoom");
		mrNavigationContainer = $("#mrNavigationContainer");
		mrTitleContainer = $("#mrTitleContainer");
		mrTitle = $("#mrTitle");
		mrMinimize = $("#mrMinimize");
		mrFullScreen = $("#mrFullScreen");
		mrMeetingDetailsButton = $("#mrMeetingDetailsButton");
		mrMeetingDetails = $("#mrMeetingDetails");
		for (counter = 1; counter <= MAX_PARTICIPANTS; counter++) {
			participantVideoContainers[counter] = $("#participantVideoContainer"
					+ counter);
			participantRemoveButtonContainers[counter] = $("#participantRemoveButtonContainer"
					+ counter);
			participantRemoveButtons[counter] = $("#participantRemoveButton"
					+ counter);
			participantVideos[counter] = $("#participantVideo" + counter);
			participantNames[counter] = $("#participantName" + counter);
			participantMessages[counter] = $("#participantMessage" + counter)
		}
		userVideoContainer = $("#userVideoContainer");
		userVideo = $("#userVideo");
		mrAudioMuteButton = $("#mrAudioMuteButton");
		mrVideoMuteButton = $("#mrVideoMuteButton");
		mrLowBandwidthButton = $("#mrLowBandwidthButton");
		mrCallButton = $("#mrCallButton");
		mrEndButton = $("#mrEndButton");
		mrMoreChoices = $("#mrMoreChoices");
		mrMoreChoicesOptions = $("#mrMoreChoicesOptions");
		addParticipant = $("#addParticipant");
		startScreenSharing = $("#startScreenSharing");
		stopScreenSharing = $("#stopScreenSharing");
		if (!ctRingTone.length)
			throw "Ring tone not defined.";
		if (!ctDisconnectTone.length)
			throw "Disconnect tone not defined.";
		if (!instantCallAddParticipant.length)
			throw "Add participant not defined.";
		if (!meetingRoom.length)
			throw "Meeting room not defined.";
		if (!mrNavigationContainer.length)
			throw "Meeting room navigation container not defined";
		if (!mrTitleContainer.length)
			throw "Meeting room title container not defined";
		if (!mrTitle.length)
			throw "Meeting room title not defined.";
		if (!mrMinimize.length)
			throw "Meeting room minimize button not defined.";
		if (!mrFullScreen.length)
			throw "Meeting room full screen button not defined.";
		if (!mrMeetingDetailsButton.length)
			throw "Meeting details button button not defined.";
		if (!mrMeetingDetails.length)
			throw "Meeting details div not defined.";
		for (counter = 1; counter <= MAX_PARTICIPANTS; counter++) {
			if (!participantVideoContainers[counter].length
					|| !participantRemoveButtonContainers[counter].length
					|| !participantRemoveButtons[counter].length
					|| !participantVideos[counter].length
					|| !participantNames[counter].length)
				throw "Participant " + counter + " video elements not defined."
		}
		if (!mrCallButton.length)
			throw "Meeting room call button not defined.";
		if (!mrLowBandwidthButton.length)
			throw "Meeting room low bandwidth button not defined.";
		if (!mrVideoMuteButton.length)
			throw "Meeting room video mute button not defined.";
		if (!mrAudioMuteButton.length)
			throw "Meeting room audio mute button not defined.";
		if (!mrEndButton.length)
			throw "Meeting room end button not defined.";
		if (!mrMoreChoices.length)
			throw "Meeting room more chocies menu not defined.";
		if (!mrMoreChoicesOptions.length)
			throw "Meeting room more chocies menu options are not defined.";
		if (!userVideoContainer.length || !userVideo.length)
			throw "User video elements not defined.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("initMeetingRoomElements", coffeeTable.error);
		return false
	}
}
function centerWindow(e, t, n) {
	try {
		if (undefined === t)
			t = 0;
		if (undefined === n)
			n = 0;
		e.css("top", Math.max(0, ($(window).height() - e.outerHeight()) / 2
				+ $(window).scrollTop())
				+ n + "px");
		e.css("left", Math.max(0, ($(window).width() - e.outerWidth()) / 2
				+ $(window).scrollLeft())
				+ t + "px");
		return true
	} catch (r) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = r;
		logError("centerWindow", coffeeTable.error);
		return false
	}
}
function highlightTitle() {
	try {
		coffeeTable.document.newTitle = coffeeTable.meeting.participants[0].name
				+ " is Calling";
		coffeeTable.document.isTitleOriginal = true;
		coffeeTable.trackers.highlightTimeOut = setInterval("changeTitle()",
				1e3);
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("highlightTitle", coffeeTable.error);
		return false
	}
}
function changeTitle() {
	try {
		if (!coffeeTable.initiator) {
			document.title = coffeeTable.document.isTitleOriginal ? coffeeTable.document.originalTitle
					: coffeeTable.document.newTitle;
			coffeeTable.document.isTitleOriginal = !coffeeTable.document.isTitleOriginal
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("changeTitle", coffeeTable.error);
		return false
	}
}
function restoreTitle() {
	try {
		clearInterval(coffeeTable.trackers.highlightTimeOut);
		if (!coffeeTable.initiator
				&& undefined !== coffeeTable.document.originalTitle
				&& null !== coffeeTable.document.originalTitle
				&& "" !== coffeeTable.document.originalTitle) {
			document.title = coffeeTable.document.originalTitle
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("restoreTitle", coffeeTable.error);
		return false
	}
}
function resetMessageBox() {
	hideMessageBoxCloseButton();
	hideMessageBoxInfo();
	hideMessageBoxImage();
	hideErrorMessageBox();
	hideAuthenticationMessageBox();
	hideAddParticipantsMessageBox();
	hideCallMessageBox();
	enableMessageBoxFormElements();
	hideAddMeetingMessage()
}
function showMessageBoxInfo(e, t) {
	ctMessageBoxInfo.html(e).show();
	if (undefined !== t) {
		ctMessageBoxInfo.delay(5e3).fadeOut("fast")
	}
}
function hideMessageBoxInfo() {
	ctMessageBoxInfo.html("").hide()
}
function showMessageBoxImage(e) {
	try {
		if (undefined !== e) {
			if ("loader" === e) {
				ctMessageBoxSuccessImage.hide();
				ctMessageBoxUserImage.hide();
				ctMessageBoxLoaderImage.show();
				ctMessageBoxImageContainer.show()
			} else if ("success" === e) {
				ctMessageBoxLoaderImage.hide();
				ctMessageBoxUserImage.hide();
				ctMessageBoxSuccessImage.show();
				ctMessageBoxImageContainer.show()
			} else if ("userImage") {
				ctMessageBoxLoaderImage.hide();
				ctMessageBoxSuccessImage.hide();
				ctMessageBoxUserImage.show();
				ctMessageBoxImageContainer.show()
			}
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("showMessageBoxImage", coffeeTable.error);
		return false
	}
}
function hideMessageBoxImage() {
	try {
		ctMessageBoxLoaderImage.hide();
		ctMessageBoxSuccessImage.hide();
		ctMessageBoxUserImage.hide();
		ctMessageBoxImageContainer.hide();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideMessageBoxImage", coffeeTable.error);
		return false
	}
}
function showMessageBoxButton1(e) {
	try {
		ctMessageBoxButton1.html(e).show();
		ctMessageBoxButtons.show();
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("showMessageBoxButton1", coffeeTable.error);
		return false
	}
}
function hideMessageBoxButton1() {
	try {
		ctMessageBoxButton1.html("").hide();
		ctMessageBoxButtons.hide();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideMessageBoxButton1", coffeeTable.error);
		return false
	}
}
function showMessageBoxButton2(e, t) {
	try {
		ctMessageBoxButton2.html(e).bind("click", function(e) {
			e.preventDefault();
			hideMessageBox();
			if (coffeeTable.waitingForParticipants && t !== undefined) {
				onWaitForParticipants()
			}
		});
		$(document).keydown(function(e) {
			if (27 === e.which) {
				hideMessageBox();
				if (coffeeTable.waitingForParticipants && t !== undefined) {
					onWaitForParticipants()
				}
			}
		});
		ctMessageBoxButton2.show();
		ctMessageBoxButtons.show();
		return true
	} catch (n) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = n;
		logError("showMessageBoxButton2", coffeeTable.error);
		return false
	}
}
function hideMessageBoxButton2() {
	try {
		ctMessageBoxButton2.unbind("click").hide().html("");
		ctMessageBoxButtons.hide();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideMessageBoxButton2", coffeeTable.error);
		return false
	}
}
function showMessageBoxCloseButton() {
	try {
		ctMessageBoxClose.bind("click", function(e) {
			e.preventDefault();
			hideMessageBox()
		});
		$(document).keydown(function(e) {
			if (27 === e.which) {
				hideMessageBox()
			}
		});
		ctMessageBoxClose.show();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("showMessageBoxCloseButton", coffeeTable.error);
		return false
	}
}
function hideMessageBoxCloseButton() {
	ctMessageBoxClose.unbind("click").hide()
}
function showMessageBox(e, t, n, r, i, s) {
	try {
		if (undefined === i || "" === i) {
			i = 0
		}
		if (undefined === s || "" === s) {
			s = 0
		}
		resetMessageBox();
		ctMessageBox.stop();
		centerWindow(ctMessageBox, ctMessageBoxWidowOffsetX - i,
				ctMessageBoxWidowOffsetY - s);
		$(window).unbind("resize").bind(
				"resize",
				function() {
					if (!ctMessageBox.is(":hidden"))
						centerWindow(ctMessageBox, ctMessageBoxWidowOffsetX,
								ctMessageBoxWidowOffsetY)
				});
		ctMessageBoxTitle.html(e);
		ctMessageBoxMainText.html(t);
		if (undefined !== n && "" !== n) {
			showMessageBoxImage(n)
		}
		if (!coffeeTable.isError)
			ctMessageBox.show();
		if (coffeeTable.isError && "meeting" === coffeeTable.service)
			ctMessageBox.show();
		if (undefined !== r && true === r) {
			ctMessageBox.delay(5e3).fadeOut("fast")
		}
		return true
	} catch (o) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = o;
		logError("showMessageBox", coffeeTable.error);
		return false
	}
}
function hideMessageBox() {
	try {
		ctMessageBoxTitle.html("");
		ctMessageBoxMainText.html("");
		ctMessageBox.hide();
		hideMessageBoxImage();
		ctTopic.val("");
		ctUsername.val("");
		ctPassword.val("");
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++) {
			ctParticipants[counter].val("")
		}
		hideMessageBoxButton1();
		hideMessageBoxButton2();
		hideMessageBoxCloseButton();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideMessageBox", coffeeTable.error);
		return false
	}
}
function showErrorMessageBox(e, t) {
	try {
		showMessageBox(e, t.message);
		ctMessageBoxDetailsPoints.html("<b>Cause : </b>" + t.detailedMessage);
		ctMessageBoxSolutionPoints.append(
				'<li class="resetList"><b>Solution : </b> </li>').append(
				t.solution);
		showMessageBoxButton1("Show More");
		ctMessageBoxButton1.unbind("click").bind("click", function(e) {
			e.preventDefault();
			if (ctMessageBoxButton1.html() === "Show More") {
				ctMessageBoxDetails.show();
				ctMessageBoxButton1.html("Show Less")
			} else if (ctMessageBoxButton1.html() === "Show Less") {
				ctMessageBoxDetails.hide();
				ctMessageBoxButton1.html("Show More")
			}
		});
		$(document).keydown(function(e) {
			if (13 === e.which) {
				if (ctMessageBoxButton1.html() === "Show More") {
					ctMessageBoxDetails.show();
					ctMessageBoxButton1.html("Show Less")
				} else if (ctMessageBoxButton1.html() === "Show Less") {
					ctMessageBoxDetails.hide();
					ctMessageBoxButton1.html("Show More")
				}
			}
		});
		showMessageBoxCloseButton();
		return true
	} catch (n) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = n;
		logError("showErrorMessageBox", coffeeTable.error);
		return false
	}
}
function hideErrorMessageBox() {
	try {
		ctMessageBoxDetailsPoints.html("");
		ctMessageBoxSolutionPoints.html("");
		ctMessageBoxDetails.hide();
		hideMessageBox();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideErrorMessageBox", coffeeTable.error);
		return false
	}
}
function showAuthenticationMessageBox(e, t) {
	try {
		showMessageBox(e, t);
		populateAuthenticationMessageBox();
		ctAddParticipantsSelectBox.change(function() {
			coffeeTable.user.type = ctAddParticipantsSelectBox.val().trim();
			if ("Initiator" === coffeeTable.user.type)
				ctVerificationCode.show();
			else if ("" !== coffeeTable.urlParameters["verification"])
				ctVerificationCode.hide();
			else if ("" === coffeeTable.urlParameters["verification"])
				ctVerificationCode.val("").hide()
		});
		ctAunthentication.show();
		ctAddParticipantsSelectBox.focus();
		showMessageBoxButton1("Enter Meeting Room");
		ctMessageBoxButton1.unbind("click").bind("click", function(e) {
			e.preventDefault();
			initUserAunthentication()
		});
		$(document).keydown(function(e) {
			if (13 === e.which && !ctAddParticipantsSelectBox.is(":focus")) {
				if (ctMessageBoxButton1.html() === "Enter Meeting Room")
					initUserAunthentication()
			}
		});
		return true
	} catch (n) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = n;
		errorHandler("showAuthenticationMessageBox", coffeeTable.error);
		return false
	}
}
function populateAuthenticationMessageBox() {
	if (undefined !== coffeeTable.urlParameters["email"]
			&& "" !== coffeeTable.urlParameters["email"]) {
		ctTextBox.val(coffeeTable.urlParameters["email"])
	} else if (undefined !== coffeeTable.urlParameters["email"]
			&& (undefined === coffeeTable.urlParameters["type"] || "" === coffeeTable.urlParameters["type"])) {
		ctTextBox.val(coffeeTable.urlParameters["email"])
	} else {
		ctAddParticipantsSelectBox.val("");
		ctTextBox.val("");
		ctVerificationCode.val("").hide()
	}
	if (undefined !== coffeeTable.urlParameters["type"]
			&& "" !== coffeeTable.urlParameters["type"]
			&& "initiator" === coffeeTable.urlParameters["type"]) {
		ctAddParticipantsSelectBox.val("Initiator");
		ctVerificationCode.show()
	} else if (undefined !== coffeeTable.urlParameters["type"]
			&& "" !== coffeeTable.urlParameters["type"]
			&& "guest" === coffeeTable.urlParameters["type"]) {
		ctAddParticipantsSelectBox.val("Guest");
		ctVerificationCode.val("").hide()
	}
}
function hideAuthenticationMessageBox() {
	try {
		ctAunthentication.hide();
		hideMessageBox();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideAuthenticationMessageBox", coffeeTable.error);
		return false
	}
}
function enableMessageBoxFormElements() {
	try {
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++) {
			ctParticipants[counter].removeAttr("disabled")
		}
		ctAddParticipantsSelectBox.removeAttr("disabled");
		ctTextBox.removeAttr("disabled");
		ctVerificationCode.removeAttr("disabled");
		ctMessageBoxButton1.removeClass("message-box-button-disabled-1");
		ctMessageBoxButton2.removeClass("message-box-button-disabled-2");
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("enableMessageBoxFormElements", coffeeTable.error);
		return false
	}
}
function disableMessageBoxFormElements() {
	try {
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++) {
			ctParticipants[counter].attr("disabled", "disabled")
		}
		ctAddParticipantsSelectBox.attr("disabled", "disabled");
		ctTextBox.attr("disabled", "disabled");
		ctVerificationCode.attr("disabled", "disabled");
		ctMessageBoxButton1.addClass("message-box-button-disabled-1");
		ctMessageBoxButton2.addClass("message-box-button-disabled-2");
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("disableMessageBoxFormElements", coffeeTable.error);
		return false
	}
}
function setButtonInWaitState(e) {
	e.attr("oldState", e.html()).html("Please wait...")
}
function restoreButtonLabel(e) {
	e.html(e.attr("oldState")).removeAttr("oldState")
}
function initUserAunthentication() {
	try {
		if (ctMessageBoxButton1.html() === "Enter Meeting Room") {
			var e = ctAddParticipantsSelectBox.val().trim();
			var t = ctTextBox.val().trim();
			var n = ctVerificationCode.val().trim();
			if (e === undefined || "" === e.trim()) {
				showMessageBoxInfo("Please select a valid participant type.");
				return false
			}
			if (t === undefined || undefined !== t && "" === t.trim()) {
				ctTextBox.val("");
				showMessageBoxInfo("Email address cannot be left blank.");
				return false
			}
			if (!emailValidationRegEx.test(t)) {
				showMessageBoxInfo("Invalid email address.");
				return false
			}
			if ("Initiator" === e
					&& (n === undefined || undefined !== n && "" === n.trim())) {
				ctVerificationCode.val("");
				showMessageBoxInfo("Please enter the verification code.");
				return false
			}
			coffeeTable.user.id = t.toLowerCase();
			coffeeTable.user.name = t;
			coffeeTable.user.email = t.toLowerCase();
			coffeeTable.user.type = e;
			coffeeTable.user.verificationCode = n;
			disableMessageBoxFormElements();
			setButtonInWaitState(ctMessageBoxButton1);
			if (!createSocketConnection())
				throw "Could not connect to the the video chat server."
		}
	} catch (r) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = r;
		errorHandler("initUserAunthentication", coffeeTable.error);
		return false
	}
}
function initRemoveParticipant(e) {
	try {
		e.removeButtonContainer.show();
		e.removeButton
				.unbind("click")
				.bind(
						"click",
						function(t) {
							t.preventDefault();
							t.stopPropagation();
							if (coffeeTable.meeting.participantCount <= 1) {
								showUserMessage(
										"Cannot remove the last participant. Please end meeting/call",
										true)
							} else {
								showRemoveParticipantMessageBox(
										coffeeTableAppName + " Meetings",
										"Are you sure you want to remove <b>"
												+ e.name + "</b>?", e)
							}
						});
		return true
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		errorHandler("initRemoveParticipant", coffeeTable.error);
		return false
	}
}
function showAddParticipantsMessageBox(e, t, n) {
	try {
		showMessageBox(e, t, "", "", 0, 50);
		if (!n) {
			showAddMeetingMessage();
			ctParticipants[1].attr("placeholder", "Participant email address");
			for (counter = 2; counter < MAX_PARTICIPANTS; counter++)
				ctParticipants[counter].hide();
			showMessageBoxButton1("Add");
			ctMessageBoxButton1.unbind("click").bind("click", function(e) {
				e.preventDefault();
				if (ctMessageBoxButton1.html() === "Add")
					addParticipantToMeetingRoom()
			});
			$(document).keydown(function(e) {
				if (13 === e.which) {
					if (ctMessageBoxButton1.html() === "Add")
						addParticipantToMeetingRoom()
				}
			})
		} else {
			showMessageBoxButton1("Send Invites");
			showAddMeetingMessage();
			ctMessageBoxButton1.unbind("click").bind("click", function(e) {
				e.preventDefault();
				if (ctMessageBoxButton1.html() === "Send Invites")
					createMeeting()
			});
			$(document).keydown(function(e) {
				if (13 === e.which) {
					if (ctMessageBoxButton1.html() === "Send Invites")
						createMeeting()
				}
			})
		}
		ctAddParticpants.show(0, function() {
			if (!coffeeTable.isAuthenticationRequired) {
				ctUsername.hide();
				ctPassword.hide()
			} else {
				ctUsername.show();
				ctPassword.show()
			}
			ctTopic.focus()
		});
		$(":input:visible").each(function(e) {
			$(this).attr("tabindex", e + 1)
		});
		if (!n) {
			showMessageBoxButton2("Cancel", true)
		} else {
			showMessageBoxButton2("Cancel")
		}
		showMessageBoxCloseButton();
		return true
	} catch (r) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = r;
		logError("showAddParticipantsMessageBox", coffeeTable.error);
		return false
	}
}
function hideAddParticipantsMessageBox() {
	try {
		hideMessageBox();
		ctAddParticpants.hide();
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++)
			ctParticipants[counter].removeClass(coffeeTableErrorBoxClass);
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideAddParticipantsMessageBox", coffeeTable.error);
		return false
	}
}
function showAddMeetingMessage() {
	try {
		ctMessageBoxAddMessage.unbind("click").click(function(e) {
			e.preventDefault();
			if (ctMessageBoxMeetingMessage.is(":visible")) {
				ctMessageBoxAddMessage.html("+ Add Message");
				ctMessageBoxMeetingMessage.hide()
			} else {
				ctMessageBoxAddMessage.html("- Hide Message");
				ctMessageBoxMeetingMessage.show()
			}
		});
		ctMessageBoxAddMessage.html("+ Add Message");
		ctMessageBoxCreateMeetingOptions.show();
		ctMessageBoxMeetingMessage.hide()
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("addMeetingMessage", coffeeTable.error);
		return false
	}
}
function hideAddMeetingMessage() {
	try {
		ctMessageBoxAddMessage.html("+ Add Message");
		ctMessageBoxCreateMeetingOptions.hide();
		ctMessageBoxMeetingMessage.hide();
		ctMessageBoxMeetingMessage.val("");
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideAddMeetingMessage", coffeeTable.error);
		return false
	}
}
function showRemoveParticipantMessageBox(e, t, n) {
	try {
		showMessageBox(e, t);
		showMessageBoxImage();
		showMessageBoxButton1("Yes");
		ctMessageBoxButton1.unbind("click").bind(
				"click",
				function(e) {
					e.preventDefault();
					if (ctMessageBoxButton1.html() === "Yes"
							&& !sendRemoveParticipant(n.id))
						throw "Could not send remove participant."
				});
		$(document).keydown(
				function(e) {
					if (13 === e.which) {
						if (ctMessageBoxButton1.html() === "Yes"
								&& !sendRemoveParticipant(n.id))
							throw "Could not send remove participant."
					}
				});
		showMessageBoxButton2("Cancel", true);
		showMessageBoxCloseButton();
		return true
	} catch (r) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = r;
		showMessageBoxInfo(coffeeTable.error.detailedMessage);
		logError("showRemoveParticipantMessageBox", coffeeTable.error);
		return false
	}
}
function hideRemoveParticipantMessageBox() {
	hideMessageBoxImage();
	hideMessageBox()
}
function showStartScreenSharingMessageBox(e, t) {
	try {
		showMessageBox(e, t);
		showMessageBoxImage();
		showMessageBoxButton1("Yes");
		ctMessageBoxButton1.unbind("click").bind(
				"click",
				function(e) {
					e.preventDefault();
					coffeeTable.screenSharing = true;
					if (ctMessageBoxButton1.html() === "Yes"
							&& !sendAddParticipant(coffeeTable.user.id
									+ "screen"))
						throw "Could not send start screen sharing."
				});
		$(document).keydown(
				function(e) {
					if (13 === e.which) {
						coffeeTable.screenSharing = true;
						if (ctMessageBoxButton1.html() === "Yes"
								&& !sendAddParticipant(coffeeTable.user.id
										+ "screen"))
							throw "Could not send start screen sharing."
					}
				});
		showMessageBoxButton2("Cancel");
		showMessageBoxCloseButton();
		return true
	} catch (n) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = n;
		showMessageBoxInfo(coffeeTable.error.detailedMessage);
		logError("showStartScreenSharingMessageBox", coffeeTable.error);
		return false
	}
}
function hideStartScreenSharingMessageBox() {
	hideMessageBoxImage();
	hideMessageBox()
}
function showCallMessageBox(e, t) {
	try {
		coffeeTable.initiator = false;
		coffeeTable.onCall = true;
		hideInstantCallMeetingRoom();
		hideMessageBox();
		ctDock.hide();
		releaseLocalMedia();
		highlightTitle();
		startRinging();
		showMessageBox(e, t);
		showMessageBoxImage("userImage");
		showMessageBoxButton1("Accept");
		clearTimeout(coffeeTable.trackers.timeout);
		coffeeTable.trackers.timeout = setTimeout(sendNoAnswer,
				coffeeTable.serverParameters.timeOut);
		ctMessageBoxButton1.unbind("click").bind(
				"click",
				function(e) {
					e.preventDefault();
					if (ctMessageBoxButton1.html() === "Accept") {
						clearTimeout(coffeeTable.trackers.timeout);
						restoreTitle();
						coffeeTable.trackers.timeout = setTimeout(sendNoAnswer,
								coffeeTable.serverParameters.timeOut);
						attachLocalMedia()
					}
				});
		showMessageBoxButton2("Reject");
		ctMessageBoxButton2.unbind("click").bind("click", function(e) {
			e.preventDefault();
			if (ctMessageBoxButton2.html() === "Reject") {
				clearTimeout(coffeeTable.trackers.timeout);
				endOffer();
				restoreTitle();
				stopRinging();
				sendReject()
			}
		});
		return true
	} catch (n) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = n;
		errorHandler("showCallMessageBox", coffeeTable.error);
		return false
	}
}
function hideCallMessageBox() {
	hideMessageBoxImage();
	hideMessageBox()
}
function createMeeting() {
	try {
		if (!storeParticipantInfo())
			return false;
		if (ctMessageBoxMeetingMessage.is(":visible")
				&& "" !== $.trim(ctMessageBoxMeetingMessage.val())) {
			coffeeTable.meeting.meetingMessage = ctMessageBoxMeetingMessage
					.val()
		} else {
			coffeeTable.meeting.meetingMessage = ""
		}
		if ("" !== $.trim(ctTopic.val())) {
			coffeeTable.meeting.topic = ctTopic.val()
		} else {
			coffeeTable.meeting.topic = ""
		}
		showMessageBox(coffeeTableAppName + " Meetings",
				"Creating a meeting room, please wait...", "loader");
		showMessageBoxCloseButton();
		if (!coffeeTable.isReady) {
			coffeeTable.isCreateMeetingSocket = true;
			initCoffeeTableInstantCall()
		} else if (coffeeTable.isReady) {
			coffeeTable.isCreateMeetingSocket = false;
			sendMeetingRoomCreateMeeting()
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("createMeeting", coffeeTable.error);
		return false
	}
}
function initScheduleMeeting(e, t, n, r, i) {
	try {
		if (undefined === e || null === e || "" === $.trim(e))
			throw "Coffee table customer id not defined.";
		if (undefined === t || null === t || "" === $.trim(t))
			throw "Coffee table app id not defined.";
		if (undefined === n || null === n || "" === $.trim(n))
			throw "Coffee table service not defined.";
		coffeeTable.service = n;
		if (undefined === r || null === r)
			throw "Coffee table authentication required flag not defined.";
		coffeeTable.isAuthenticationRequired = r;
		if (undefined === i || null === i)
			throw "Coffee table create meeting user flag not defined.";
		coffeeTable.isCreateMeetingUser = i;
		if (!coffeeTable.isReady) {
			if (!initCoffeeTableComponents(e, t))
				throw "Could not initiate the coffee table components.";
			if (!initMessageBoxElements()) {
				alert("Message box elements are not defined. Could not start video calling system. Please contact your system admin.");
				throw "Could not initialize message box elements."
			}
			if (!checkBrowserSupport())
				throw 'Your web browser does not support Video Calling. Please switch to <a href="https://www.google.com/intl/en/chrome/browser/">Chrome version 24.0 or higher</a> or <a href="http://www.mozilla.org/en-US/">Firefox version 22.0 or higher</a> or <a href="http://www.opera.com/">Opera version 22.0 or higher</a>';
			if (coffeeTable.socket.url === undefined
					|| coffeeTable.socket.url === null
					|| coffeeTable.socket.url === "")
				throw "Video chat server address is not specified.";
			if (coffeeTable.socket.conn === undefined)
				throw "Could not connect to the the video chat server.";
			if (!coffeeTable.isCreateMeetingUser) {
				showMessageBox(coffeeTableAppName + " Meetings",
						"Creating a meeting room, please wait...", "loader");
				showMessageBoxCloseButton();
				coffeeTable.isCreateMeetingSocket = true;
				initCoffeeTableInstantCall()
			} else if (coffeeTable.isCreateMeetingUser) {
				showAddParticipantsMessageBox(
						coffeeTableAppName + " Meetings",
						"Enter meeting topic and upto 4 meeting participant email id's.",
						true)
			}
		} else if (coffeeTable.isReady) {
			if (!coffeeTable.isCreateMeetingUser) {
				coffeeTable.participants = [ {
					participantId : coffeeTable.user.id,
					participantName : coffeeTable.user.name,
					participantEmailId : coffeeTable.user.email
				}, {
					participantId : calleeId,
					participantName : calleeName,
					participantEmailId : calleeEmailId
				} ];
				sendMeetingRoomCreateMeeting()
			} else if (coffeeTable.isCreateMeetingUser) {
				showAddParticipantsMessageBox(
						coffeeTableAppName + " Meetings",
						"Enter meeting topic and upto 4 meeting participant email id's.",
						true)
			}
		}
		return true
	} catch (s) {
		coffeeTable.isError = true;
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = s;
		errorHandler("initScheduleMeeting", coffeeTable.error);
		return false
	}
}
function storeParticipantInfo() {
	try {
		maxParticipantCounter = MAX_PARTICIPANTS;
		if (coffeeTable.isAuthenticationRequired) {
			if (!storeUserAuthenticationInfo())
				return false;
			coffeeTable.user.id = coffeeTable.user.authenticationName;
			coffeeTable.user.name = coffeeTable.user.authenticationName;
			coffeeTable.user.email = coffeeTable.user.authenticationName
		} else if (!coffeeTable.isAuthenticationRequired) {
			coffeeTable.user.id = callerId;
			coffeeTable.user.name = callerName;
			coffeeTable.user.email = callerEmailId
		}
		coffeeTable.participants[0] = {
			participantId : coffeeTable.user.id,
			participantName : coffeeTable.user.name,
			participantEmailId : coffeeTable.user.email
		};
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++) {
			if ("" !== ctParticipants[counter].val()
					&& validateEmailId(ctParticipants[counter],
							ctParticipants[counter].val().trim())) {
				if (-1 === coffeeTable.participants
						.indexOf(ctParticipants[counter].val().trim())) {
					coffeeTable.participants.push({
						participantId : ctParticipants[counter].val().trim()
								.toLowerCase(),
						participantName : ctParticipants[counter].val().trim(),
						participantEmailId : ctParticipants[counter].val()
								.trim().toLowerCase()
					})
				}
			} else if ("" === ctParticipants[counter].val().trim()) {
				maxParticipantCounter--
			}
		}
		if (1 === maxParticipantCounter) {
			showMessageBoxInfo("Please enter participant(s). Atleast one participant is required to create a meeting.");
			ctParticipants[1].addClass(coffeeTableErrorBoxClass);
			return false
		}
		for (counter = 1; counter < MAX_PARTICIPANTS; counter++) {
			if (ctParticipants[counter].attr("valid") === "false")
				return false
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = e;
		errorHandler("storeParticipantInfo", coffeeTable.error);
		return false
	}
}
function storeUserAuthenticationInfo() {
	try {
		if ("" === ctUsername.val().trim()) {
			showMessageBoxInfo("Please enter your username for authentication.");
			ctUsername.attr("valid", false).addClass(coffeeTableErrorBoxClass);
			return false
		} else {
			coffeeTable.user.authenticationName = ctUsername.val().trim()
					.toLowerCase();
			ctUsername.attr("valid", true)
					.removeClass(coffeeTableErrorBoxClass).addClass(
							"add-participant-text-box")
		}
		if ("" === ctPassword.val().trim()) {
			showMessageBoxInfo("Please enter your password for authentication.");
			ctPassword.attr("valid", false).addClass(coffeeTableErrorBoxClass);
			return false
		} else {
			coffeeTable.user.authenticationPassword = ctPassword.val().trim();
			ctPassword.attr("valid", true)
					.removeClass(coffeeTableErrorBoxClass).addClass(
							"add-participant-text-box")
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = e;
		errorHandler("storeUserAuthenticationInfo", coffeeTable.error);
		return false
	}
}
function validateEmailId(e, t) {
	try {
		if ("" === t || !emailValidationRegEx.test(t)) {
			e.attr("valid", false).addClass(coffeeTableErrorBoxClass);
			throw "Please enter valid email address."
		} else if (coffeeTable.user.id === t && undefined !== e) {
			e.attr("valid", false).addClass(coffeeTableErrorBoxClass);
			throw "You cannot put your own email address as a participant."
		} else if (emailValidationRegEx.test(t) && undefined !== e) {
			e.attr("valid", true).removeClass(coffeeTableErrorBoxClass)
					.addClass("add-participant-text-box")
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = n;
		showMessageBoxInfo(coffeeTable.error.detailedMessage);
		logError("validateEmailId", coffeeTable.error);
		return false
	}
}
function sendInstantCallCreateMeeting() {
	try {
		if (!sendCommand({
			userId : coffeeTable.user.id,
			userName : coffeeTable.user.name,
			emailId : coffeeTable.user.email,
			type : "createMeeting",
			participants : coffeeTable.participants,
			isAuthenticationRequired : false,
			service : "instantCall"
		}))
			throw "Could not send create meeting command to the server.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("sendInstantCallCreateMeeting", coffeeTable.error);
		return false
	}
}
function sendMeetingRoomCreateMeeting() {
	try {
		disableMessageBoxFormElements();
		setButtonInWaitState(ctMessageBoxButton1);
		var e = {
			userId : coffeeTable.user.id,
			userName : coffeeTable.user.name,
			emailId : coffeeTable.user.email,
			type : "createMeeting",
			participants : coffeeTable.participants,
			meetingTopic : coffeeTable.meeting.topic,
			meetingMessage : coffeeTable.meeting.meetingMessage,
			isAuthenticationRequired : coffeeTable.isAuthenticationRequired,
			service : "meeting"
		};
		if (coffeeTable.isAuthenticationRequired) {
			e.authenticationName = coffeeTable.user.authenticationName;
			e.authenticationPassword = coffeeTable.user.authenticationPassword
		}
		if (!sendCommand(e))
			throw "Could not send create meeting command to the server.";
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		logError("sendMeetingRoomCreateMeeting", coffeeTable.error);
		return false
	}
}
function onCreateMeeting(e, t) {
	try {
		if (undefined !== e.error && "true" === e.error) {
			throw e.errorMessage
		}
		if (e.userId === undefined)
			throw "User id not defined.";
		if (e.meeting === undefined)
			throw "Meeting not defined.";
		if (e.participants === undefined)
			throw "Participants not defined.";
		if (e.service === undefined)
			throw "Service not defined.";
		if ("meeting" === e.service) {
			showMessageBox(
					coffeeTableAppName + " Meetings",
					"Meeting created successfully.  Please check your email for the following: \n    <br /><b>a)</b> Instructions to login in a meeting, \n    <br /><b>b)</b> Validity of meeting \n    <br /><b>c)</b> Participant details.",
					"success");
			coffeeTable.participants = [];
			showMessageBoxCloseButton();
			if (typeof t === "function" && coffeeTable.isCreateMeetingSocket)
				t();
			else if (typeof t !== "function"
					&& coffeeTable.isCreateMeetingSocket)
				throw "Invalid Call Back Type" + typeof t
		} else if ("instantCall" === e.service) {
			coffeeTable.meeting.id = e.meeting.id;
			$.each(e.meeting.participants, function(e, t) {
				if (coffeeTable.user.id !== t.userId)
					coffeeTable.meeting.participants.push(getNewParticipant(t))
			});
			bindCoffeeTableButtonEvents();
			showParticipant(coffeeTable.meeting.participants[0]);
			showUserMessage("Calling "
					+ coffeeTable.meeting.participants[0].name);
			showInstantCallMeetingRoom();
			setButtonState(mrEndButton, "enabled", "End");
			if (!sendInstantCallRequest(coffeeTable.meeting.participants[0]))
				throw "Could not send the ring"
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onCreateMeeting", coffeeTable.error);
		return false
	}
}
function onCreateMeetingSuccess() {
	try {
		sendQuit("instantCall");
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("onCreateMeetingSuccess", coffeeTable.error);
		return false
	}
}
function sendInstantCallRequest(e) {
	try {
		if (!sendCommand({
			fromParticipantId : coffeeTable.user.id,
			toParticipantId : e.id,
			type : "instantCallRequest",
			meetingId : coffeeTable.meeting.id,
			service : coffeeTable.service
		}))
			throw "Could not send instant call request to the server.";
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		logError("sendInstantCallRequest", coffeeTable.error);
		return false
	}
}
function onInstantCallRequest(e) {
	try {
		if (undefined !== e.error && "true" === e.error) {
			showServerError(e, "main");
			sendParticipantOffline();
			stopRinging();
			playDisconnect();
			setButtonState(mrEndButton, "enabled", "End");
			if (coffeeTable.meeting.participantCount === 1
					&& e.toParticipantId !== undefined) {
				coffeeTable.peer.id = e.toParticipantId.toLowerCase();
				coffeeTable.peer.name = e.toParticipantId;
				coffeeTable.peer.emailId = e.toParticipantId.toLowerCase();
				setButtonState(mrCallButton, "enabled", "Call")
			}
			disableAllToggleButtons();
			resetCoffeeTableFlags();
			return true
		}
		if (e.meeting === undefined || e.meetingId === "")
			throw "Invalid meeting details.";
		if (e.fromParticipantId === undefined || e.fromParticipantId === "")
			throw "Invalid Participant Id.";
		if (e.toParticipantId === undefined || e.toParticipantId === ""
				|| e.toParticipantId !== coffeeTable.user.id)
			throw "Invalid user Id.";
		coffeeTable.meeting.id = e.meeting.id;
		$.each(e.meeting.participants, function(e, t) {
			if (coffeeTable.user.id !== t.userId)
				coffeeTable.meeting.participants.push(getNewParticipant(t))
		});
		hideMessageBox();
		setButtonState(mrEndButton, "enabled", "End");
		showCallMessageBox(coffeeTableAppName + " Instant Call", "<b>"
				+ coffeeTable.meeting.participants[0].name + "</b> is calling");
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onInstantCallRequest", coffeeTable.error);
		return false
	}
}
function initCoffeeTable(e, t, n) {
	try {
		if (true === coffeeTable.isInitializing)
			return true;
		if (true === coffeeTable.isReady)
			return true;
		if (false === coffeeTable.meetingEnded)
			hideMessageBox();
		if (undefined === n || null === n || "" === $.trim(n))
			throw "Coffee table service not defined.";
		coffeeTable.service = n;
		if (undefined === e || null === e || "" === $.trim(e))
			throw "Coffee table customer id not defined.";
		if (undefined === t || null === t || "" === $.trim(t))
			throw "Coffee table app id not defined.";
		if (!getURLParameters() && 0 === coffeeTable.urlParameters.length)
			throw "Could not get the coffee table user details.";
		if (!initCoffeeTableComponents(e, t))
			throw "Could not initiate the coffee table components.";
		if (!initMessageBoxElements()) {
			alert("Message box elements are not defined. Could not start video calling system. Please contact your system admin.");
			throw "Could not initialize message box elements."
		}
		if (!checkBrowserSupport())
			throw 'Your web browser does not support Video Calling. Please switch to <a href="https://www.google.com/intl/en/chrome/browser/">Chrome version 24.0 or higher</a> or <a href="http://www.mozilla.org/en-US/">Firefox version 22.0 or higher</a> or <a href="http://www.opera.com/">Opera version 22.0 or higher</a>';
		if (!initDockElements())
			throw "Could not initialize dock elements.";
		if (!initMeetingRoomElements())
			throw "Could not initialize meeting room elements.";
		if ("instantCall" === coffeeTable.service)
			mrTitle.html(coffeeTableAppName + " Instant Call");
		else if ("meeting" === coffeeTable.service)
			mrTitle.html(coffeeTableAppName + " Meeting Room");
		navigator.getUserMedia = getNormalizedUserMedia();
		if (!navigator.getUserMedia)
			throw 'Your web browser does not support Video Calling. Please switch to <a href="https://www.google.com/intl/en/chrome/browser/">Chrome version 24.0 or higher</a> or <a href="http://www.mozilla.org/en-US/">Firefox version 22.0 or higher</a> or <a href="http://www.opera.com/">Opera version 22.0 or higher</a>';
		attachTipsy();
		if (coffeeTable.socket.url === undefined
				|| coffeeTable.socket.url === null
				|| coffeeTable.socket.url === "")
			throw "Video chat server address is not specified.";
		if (coffeeTable.socket.conn === undefined)
			throw "Could not connect to the the video chat server.";
		if ("instantCall" === coffeeTable.service) {
			initCoffeeTableInstantCall()
		} else if ("meeting" === coffeeTable.service) {
			initCoffeeTableMeetings()
		}
		return true
	} catch (r) {
		coffeeTable.isError = true;
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = r;
		errorHandler("initCoffeeTable", coffeeTable.error);
		return false
	}
}
function initCoffeeTableInstantCall() {
	try {
		if (!coffeeTable.isAuthenticationRequired) {
			if (null === callerId || undefined === callerId || "" === callerId)
				throw "User Id is not defined.";
			coffeeTable.user.id = callerId.toLowerCase();
			if (null === callerName || undefined === callerName
					|| "" === callerName)
				throw "User Name is not defined.";
			coffeeTable.user.name = callerName;
			if (null === callerEmailId || undefined === callerEmailId
					|| "" === callerEmailId)
				throw "User Email Id is not defined.";
			coffeeTable.user.email = callerEmailId.toLowerCase()
		}
		coffeeTable.user.videoElement = document.getElementById("userVideo");
		coffeeTable.document.originalTitle = document.title;
		if (!createSocketConnection())
			throw "Could not connect to the video chat server.";
		return true
	} catch (e) {
		coffeeTable.isError = true;
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("initCoffeeTableInstantCall", coffeeTable.error);
		return false
	}
}
function showInstantCallMeetingRoom() {
	try {
		meetingRoom.removeClass("meeting-room").addClass("instant-call-window");
		centerWindow(meetingRoom, instantCallWidowOffsetX,
				instantCallWidowOffsetY);
		$(window).unbind("resize").bind(
				"resize",
				function() {
					if (!meetingRoom.is(":hidden"))
						centerWindow(meetingRoom, instantCallWidowOffsetX,
								instantCallWidowOffsetY)
				});
		meetingRoom.show();
		mrCallButton.show();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("showInstantCallMeetingRoom", coffeeTable.error);
		return false
	}
}
function hideInstantCallMeetingRoom() {
	try {
		meetingRoom.removeClass("instant-call-window").addClass("meeting-room");
		mrCallButton.hide();
		meetingRoom.hide();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("hideInstantCallMeetingRoom", coffeeTable.error);
		return false
	}
}
function initCoffeeTableMeetings() {
	try {
		meetingRoom.removeClass("instant-call-window").addClass("meeting-room")
				.show();
		coffeeTable.user.videoElement = document.getElementById("userVideo");
		coffeeTable.user.videoElement.style.display = "none";
		if (null === coffeeTable.urlParameters["meetingId"]
				|| undefined === coffeeTable.urlParameters["meetingId"]
				|| "" === coffeeTable.urlParameters["meetingId"])
			throw "Meeting Id is not defined.";
		coffeeTable.meeting.id = coffeeTable.urlParameters["meetingId"];
		attachLocalMedia();
		return true
	} catch (e) {
		coffeeTable.isError = true;
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("initCoffeeTableMeetings", coffeeTable.error);
		return false
	}
}
function createSocketConnection() {
	try {
		coffeeTable.socket.conn = new WebSocket(coffeeTable.socket.url);
		coffeeTable.socket.conn.onopen = sendInit;
		coffeeTable.socket.conn.onclose = closeSocket;
		coffeeTable.socket.conn.onerror = showError;
		coffeeTable.socket.conn.onmessage = processMessage;
		return true
	} catch (e) {
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = e;
		errorHandler("createSocketConnection", coffeeTable.error);
		return false
	}
}
function showError(e) {
	if ("meeting" === coffeeTable.service)
		coffeeTable.isError = true;
	coffeeTable.isReady = false;
	coffeeTable.error.code = "VC101";
	coffeeTable.error.detailedMessage = "Could not connect to video chat server! Please contact your system admin!";
	if (coffeeTable.isCreateMeetingSocket) {
		showMessageBox(
				coffeeTableAppName + " Meetings",
				"Could not connect to video chat server. Please contact your system admin or try later.");
		showMessageBoxCloseButton()
	} else {
		errorHandler("showError", coffeeTable.error)
	}
}
function sendCommand(e) {
	try {
		if (e.type === undefined || e.type === null || e.type === "")
			throw "No command defined! Please contact your system admin!";
		if (coffeeTable.customerId === undefined
				|| coffeeTable.customerId === null
				|| coffeeTable.customerId === "")
			throw "Customer Id not defined! Please contact your system admin!";
		if (coffeeTable.appId === undefined || coffeeTable.appId === null
				|| coffeeTable.appId === "")
			throw "App Id not defined! Please contact your system admin!";
		e.customerId = coffeeTable.customerId;
		e.appId = coffeeTable.appId;
		switch (e.type) {
		case "participantOnline":
		case "participantOffline":
		case "init":
		case "heartbeat":
		case "createMeeting":
		case "instantCallRequest":
		case "addParticipant":
		case "removeParticipant":
		case "offer":
		case "reject":
		case "answer":
		case "noAnswer":
		case "candidate":
		case "meetingStarted":
		case "videoMute":
		case "videoUnmute":
		case "audioMute":
		case "audioUnmute":
		case "sync":
		case "quit":
		case "logClientError":
			return sendMessage(JSON.stringify(e));
			break;
		default:
			throw "Command not found! Please contact your system admin!"
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("sendCommand", coffeeTable.error);
		return false
	}
}
function sendMessage(e) {
	try {
		logger("Sending - " + e);
		if (coffeeTable.socket.conn.readyState === coffeeTable.socket.conn.OPEN) {
			coffeeTable.socket.conn.send(e);
			return true
		}
		return false
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		logError("sendMessage", coffeeTable.error);
		return false
	}
}
function processMessage(e) {
	try {
		var t = JSON.parse(e.data);
		logger("Received - " + JSON.stringify(t));
		if (t === undefined || t === null || t === "")
			throw "Message not found. Cannot process empty message";
		switch (t.type) {
		case "error":
			onErrorFromServer(t);
			break;
		case "participantOnline":
			onParticipantOnline(t);
			break;
		case "participantOffline":
			onParticipantOffline(t);
			break;
		case "waitForInitator":
			onWaitForInitiator(t);
			break;
		case "waitForParticipants":
			onWaitForParticipants();
			break;
		case "initiatorTimeOut":
			onInitiatorTimeOut(t);
			break;
		case "init":
			onInit(t);
			break;
		case "exists":
			onExists(t);
			break;
		case "heartbeat":
			onCoffeeTableHeartbeat(t);
			break;
		case "createMeeting":
			onCreateMeeting(t, onCreateMeetingSuccess);
			break;
		case "instantCallRequest":
			onInstantCallRequest(t);
			break;
		case "meetingExpired":
			onMeetingExpired(t);
			break;
		case "meetingFull":
			onMeetingFull(t);
			break;
		case "offer":
			onOffer(t);
			break;
		case "answer":
			onAnswer(t);
			break;
		case "noAnswer":
		case "busy":
		case "reject":
			onBusy(t);
			break;
		case "incoming":
			onIncoming(t);
			break;
		case "candidate":
			onIceCandidate(t);
			break;
		case "videoMute":
		case "videoUnmute":
		case "audioMute":
		case "audioUnmute":
			onToggleMute(t);
			break;
		case "sync":
			onSync(t);
			break;
		case "addParticipant":
			onAddParticipant(t);
			break;
		case "removeParticipant":
			onRemoveParticipant(t);
			break
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("processMessage", coffeeTable.error);
		return false
	}
}
function shutdownSocket() {
	try {
		if (coffeeTable.socket.conn !== null
				&& coffeeTable.socket.conn.readyState === coffeeTable.socket.conn.OPEN) {
			coffeeTable.socket.conn.close();
			delete coffeeTable.socket.conn;
			return true
		} else
			return false
	} catch (e) {
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = e;
		logError("shutdownSocket", coffeeTable.error);
		return false
	}
}
function closeSocket(e) {
	try {
		if (coffeeTable.isCreateMeetingSocket) {
			clearInterval(coffeeTable.trackers.heartBeat);
			clearInterval(coffeeTable.trackers.serverHeartBeat);
			coffeeTable.isReady = false;
			coffeeTable.isInitializing = false;
			coffeeTable.isCreateMeetingSocket = false;
			return true
		}
		endCoffeeTable();
		clearInterval(coffeeTable.trackers.heartBeat);
		clearInterval(coffeeTable.trackers.serverHeartBeat);
		coffeeTable.isReady = false;
		coffeeTable.isInitializing = false;
		if (null !== coffeeTable.socket.conn)
			delete coffeeTable.socket.conn;
		if ("meeting" === coffeeTable.service) {
			if (!coffeeTable.isError) {
				showMessageBox(coffeeTableAppName + " Meetings",
						"Meeting ended. Refresh the page to re-login else just close this page.")
			}
			coffeeTable.isError = false;
			return true
		}
		switch (coffeeTable.browserName) {
		case "Chrome":
			if (coffeeTable.browserVersion < 24)
				break;
			else
				coffeeTable.trackers.timeout = setInterval(reconnectWebsocket,
						1e3);
			break;
		case "Firefox":
			if (coffeeTable.browserVersion < 22)
				break;
			else
				coffeeTable.trackers.timeout = setInterval(reconnectWebsocket,
						1e3);
			break;
		case "Opera":
			if (coffeeTable.browserVersion < 22)
				break;
			else
				coffeeTable.trackers.timeout = setInterval(reconnectWebsocket,
						1e3);
			break
		}
		coffeeTable.isError = false;
		return true
	} catch (t) {
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = t;
		errorHandler("closeSocket", coffeeTable.error);
		return false
	}
}
function reconnectWebsocket() {
	try {
		if ("meeting" === coffeeTable.service)
			hideMessageBox();
		if ("instantCall" === coffeeTable.service)
			ctNotification.html("").hide();
		coffeeTable.trackers.reconnectionTimeOut = coffeeTable.trackers.reconnectionTimeOut - 1e3;
		if (coffeeTable.trackers.reconnectionTimeOut < 0) {
			clearInterval(coffeeTable.trackers.timeout);
			coffeeTable.trackers.reconnectionTimeOut = 3e4;
			if (false === coffeeTable.isReady
					&& "instantCall" === coffeeTable.service) {
				initCoffeeTable(coffeeTable.customerId, coffeeTable.appId,
						"instantCall")
			} else if (false === coffeeTable.isReady
					&& "meeting" === coffeeTable.service) {
				initCoffeeTable(coffeeTable.customerId, coffeeTable.appId,
						"meeting")
			}
			return true
		}
		if (false === coffeeTable.isReady && false === coffeeTable.meetingEnded
				&& "meeting" === coffeeTable.service) {
			showMessageBox(
					coffeeTableAppName + " Meetings",
					"Please wait while we try to \n                reconnect to the video chat server in "
							+ coffeeTable.trackers.reconnectionTimeOut
							/ 1e3
							+ " seconds.")
		} else if (false === coffeeTable.isReady
				&& false === coffeeTable.meetingEnded
				&& "instantCall" === coffeeTable.service) {
			ctNotification
					.html("Please wait while we try to reconnect with video calling server in "
							+ coffeeTable.trackers.reconnectionTimeOut
							/ 1e3
							+ " seconds.");
			ctNotification.css({
				width : "100%",
				color : "red"
			});
			ctNotification.show()
		} else
			coffeeTable.trackers.reconnectionTimeOut = 3e4;
		return true
	} catch (e) {
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = e;
		errorHandler("reconnectWebsocket", coffeeTable.error);
		return false
	}
}
function sendInit() {
	try {
		"instantCall" === coffeeTable.service ? sendInitInstantCall()
				: sendInitMeeting();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		logError("sendInit", coffeeTable.error);
		return false
	}
}
function sendInitInstantCall() {
	try {
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (!sendCommand({
			type : "init",
			userId : coffeeTable.user.id,
			service : coffeeTable.service
		}))
			throw "Could not send the init instant call command to the server.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("sendInitInstantCall", coffeeTable.error);
		shutdownSocket();
		return false
	}
}
function sendInitMeeting() {
	try {
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (coffeeTable.user.name === undefined
				|| coffeeTable.user.name === null
				|| coffeeTable.user.name === "")
			throw "User name not defined.";
		if (coffeeTable.user.email === undefined
				|| coffeeTable.user.email === null
				|| coffeeTable.user.email === "")
			throw "User email id not defined.";
		if (coffeeTable.meeting.id === undefined
				|| coffeeTable.meeting.id === null
				|| coffeeTable.meeting.id === "")
			throw "Meeting Id not defined.";
		if (!sendCommand({
			type : "init",
			userId : coffeeTable.user.id,
			userName : coffeeTable.user.name,
			emailId : coffeeTable.user.email,
			userType : coffeeTable.user.type,
			verificationCode : coffeeTable.user.verificationCode,
			meetingId : coffeeTable.meeting.id,
			service : coffeeTable.service
		}))
			throw "Could not send the init meeting command to the server.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("sendInitMeeting", coffeeTable.error);
		shutdownSocket();
		return false
	}
}
function onInit(e) {
	try {
		coffeeTable.serverParameters = e.serverParameters;
		if (e.userId === undefined)
			throw "User id not defined.";
		if (e.service === undefined)
			throw "Service not defined.";
		if (undefined !== e.error && "true" === e.error) {
			coffeeTable.isError = true;
			if ("meeting" === coffeeTable.service) {
				showServerError(e, "info");
				ctMessageBoxButton1.unbind("click").bind("click", function(e) {
					e.preventDefault();
					initUserAunthentication()
				});
				$(document)
						.keydown(
								function(e) {
									if (13 === e.which
											&& !ctAddParticipantsSelectBox
													.is(":focus")) {
										if (ctMessageBoxButton1.html() === "Enter Meeting Room")
											initUserAunthentication()
									}
								})
			} else if ("instantCall" === coffeeTable.service) {
				throw e.errorMessage
			}
			return true
		}
		if (undefined === coffeeTable.serverParameters.lowThresholdCounter
				|| "" === coffeeTable.serverParameters.lowThresholdCounter
				|| null === coffeeTable.serverParameters.lowThresholdCounter)
			throw "Low threshold is not defined";
		if (undefined === coffeeTable.serverParameters.highThresholdCounter
				|| "" === coffeeTable.serverParameters.highThresholdCounter
				|| null === coffeeTable.serverParameters.highThresholdCounter)
			throw "High threshold is not defined";
		if (undefined === coffeeTable.serverParameters.initiatorOfflineTimeOut
				|| "" === coffeeTable.serverParameters.initiatorOfflineTimeOut
				|| null === coffeeTable.serverParameters.initiatorOfflineTimeOut)
			throw "Initiator offline timeout is not defined";
		if (undefined === coffeeTable.serverParameters.maxParticipants
				|| "" === coffeeTable.serverParameters.maxParticipants
				|| null === coffeeTable.serverParameters.maxParticipants)
			throw "Max participant count not defined";
		if (e.userId === coffeeTable.user.id) {
			coffeeTable.stats.lowThresholdCounter = coffeeTable.serverParameters.lowThresholdCounter;
			coffeeTable.stats.highThresholdCounter = coffeeTable.serverParameters.highThresholdCounter;
			coffeeTable.trackers.initiatorOfflineTimeOut = coffeeTable.serverParameters.initiatorOfflineTimeOut;
			coffeeTable.trackers.heartBeat = setInterval(
					sendCoffeeTableHeartBeat,
					coffeeTable.serverParameters.timeOut / 2);
			coffeeTable.lastHeartbeatTime = $.now();
			coffeeTable.trackers.serverHeartBeat = setInterval(
					checkServerAlive, coffeeTable.serverParameters.timeOut);
			MAX_PARTICIPANTS = coffeeTable.serverParameters.maxParticipants;
			hideMessageBox();
			coffeeTable.isReady = true;
			if ("meeting" === coffeeTable.service) {
				coffeeTable.meeting.validityTime = e.meeting.validityTime;
				coffeeTable.meeting.meetingTopic = e.meeting.meetingTopic;
				$.each(e.meeting.participants, function(e, t) {
					if (coffeeTable.user.id !== t.userId) {
						coffeeTable.meeting.participants
								.push(getNewParticipant(t))
					} else if (coffeeTable.user.id === t.userId
							&& 1 === parseInt(t.priority)) {
						coffeeTable.initiator = true
					}
				});
				for ( var t = 0; t < coffeeTable.meeting.participants.length; t++)
					showParticipant(coffeeTable.meeting.participants[t]);
				meetingRoom.show();
				if (!sendParticipantOnline())
					throw "Could not send participant online command.";
				displayMeetingDetails()
			} else if ("instantCall" === coffeeTable.service
					&& coffeeTable.isCreateMeetingSocket) {
				if (!coffeeTable.isCreateMeetingUser) {
					coffeeTable.participants = [ {
						participantId : coffeeTable.user.id,
						participantName : coffeeTable.user.name,
						participantEmailId : coffeeTable.user.email
					}, {
						participantId : calleeId,
						participantName : calleeName,
						participantEmailId : calleeEmailId
					} ]
				}
				sendMeetingRoomCreateMeeting()
			} else if ("instantCall" === coffeeTable.service
					&& !coffeeTable.isCreateMeetingSocket) {
				ctNotification.html("").hide()
			}
		} else {
			throw "Sorry you do not have the perimission to use "
					+ coffeeTableAppName + " Video Meeting."
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onInit", coffeeTable.error);
		shutdownSocket();
		return false
	}
}
function displayMeetingDetails() {
	try {
		mrMeetingDetailsButton.show();
		mrMeetingDetailsButton.unbind("mouseover mouseout");
		mrMeetingDetailsButton
				.bind(
						"mouseover",
						function(e) {
							var t = "";
							var n = "";
							for ( var r = 0; r < coffeeTable.meeting.participants.length; r++) {
								if (coffeeTable.meeting.participants[r].isInitiator) {
									t = coffeeTable.meeting.participants[r].name
								} else {
									n += coffeeTable.meeting.participants[r].name
											+ " ,"
								}
							}
							if (coffeeTable.initiator === true) {
								t = "You";
								n = n.slice(0, -2)
							}
							if ("" === n && coffeeTable.initiator !== true) {
								n = "You"
							} else if (coffeeTable.initiator !== true) {
								n = n.slice(0, -2) + " and You"
							}
							var i = '<table class="resetList">';
							if (undefined !== coffeeTable.meeting.meetingTopic
									&& "" !== coffeeTable.meeting.meetingTopic) {
								i += '<tr><td><b>Topic:</b></td><td style="font-size:14px">'
										+ coffeeTable.meeting.meetingTopic
										+ "</td></tr>"
							}
							i += "<tr><td><b>Meeeting Id:</b></td><td>"
									+ coffeeTable.meeting.id + "</td></tr>";
							i += "<tr><td><b>Initiator:</b></td><td>" + t
									+ "</td></tr>";
							i += "<tr><td><b>Participant(s): </b></td><td>";
							i += n;
							i += "</td></tr>";
							i += "<tr><td><b>Valid till: </b></td><td>"
									+ coffeeTable.meeting.validityTime
									+ "</td></tr>";
							i += "</table>";
							i += '<div class="meeting-details-note">Note : \n        Only initiator can add or remove participants</div>';
							var s = mrMeetingDetailsButton.position();
							mrMeetingDetails.css("top", s.top + 30);
							mrMeetingDetails.css("left", s.left - 250);
							mrMeetingDetails.html(i);
							mrMeetingDetails.show()
						});
		mrMeetingDetailsButton.bind("mouseout", function(e) {
			mrMeetingDetails.hide()
		});
		return true
	} catch (e) {
		return false
	}
}
function sendCoffeeTableHeartBeat() {
	try {
		if (undefined === coffeeTable.user.id)
			throw "User Id not defined.";
		if (!sendCommand({
			type : "heartbeat",
			userId : coffeeTable.user.id,
			service : coffeeTable.service
		}))
			throw "Could not send heart beat command.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("sendCoffeeTableHeartBeat", coffeeTable.error);
		return false
	}
}
function onCoffeeTableHeartbeat(e) {
	try {
		if (e.userId === undefined)
			throw "User id not defined.";
		if (undefined !== e.error && "true" === e.error) {
			coffeeTable.isError = true;
			throw e.errorMessage
		}
		coffeeTable.lastHeartbeatTime = $.now();
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onCoffeeTableHeartbeat", coffeeTable.error);
		return false
	}
}
function checkServerAlive() {
	try {
		if ($.now() - coffeeTable.lastHeartbeatTime >= coffeeTable.serverParameters.timeOut)
			closeSocket();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("checkServerAlive", coffeeTable.error);
		return false
	}
}
function onExists(e) {
	try {
		showMessageBox(coffeeTableAppName + " Meeting Room Error",
				"Duplicate session. Please close this window.");
		coffeeTable.isError = true;
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onExists", coffeeTable.error);
		return false
	}
}
function showServerError(e, t) {
	try {
		switch (t) {
		case "info":
			restoreButtonLabel(ctMessageBoxButton1);
			enableMessageBoxFormElements();
			showMessageBoxInfo(e.errorMessage);
			coffeeTable.meetingEnded = true;
			break;
		case "main":
			showUserMessage(e.errorMessage, true);
			break;
		case "message":
			showMessageBox(coffeeTableAppName + " meetings", e.errorMessage);
			showMessageBoxCloseButton();
			break
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		logError("showServerError :" + coffeeTable.error);
		return false
	}
}
function onErrorFromServer(e) {
	coffeeTable.error.code = "VC107";
	coffeeTable.error.detailedMessage = e.errorMessage;
	errorHandler("onErrorFromServer", coffeeTable.error);
	return false
}
function onMeetingExpired(e) {
	try {
		if (e.userId === undefined)
			throw "User id not defined.";
		if (e.meetingId === undefined)
			throw "Meeting id not defined.";
		if (e.meeting.validityTime === undefined)
			throw "Meeting not defined.";
		if (e.emailId === undefined)
			throw "Customer id not defined.";
		showMessageBox(
				coffeeTableAppName + " Meetings",
				"Sorry, \nthe meeting you are trying to connect has expired! \nMeeting was valid till <b>"
						+ e.meeting.validityTime + "</b>.");
		return true
	} catch (t) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onMeetingExpired", coffeeTable.error);
		return false
	}
}
function onMeetingFull(e) {
	try {
		if (e.userId === undefined)
			throw "User id not defined.";
		if (e.meetingId === undefined)
			throw "Meeting id not defined.";
		if (e.customerId === undefined)
			throw "Customer Id not defined.";
		if (e.participant === undefined)
			throw "Participant not defined.";
		showMessageBox(
				coffeeTableAppName + " Instant Call",
				"Max participant limit reached. You cannot add more participants.",
				"", true);
		showMessageBoxCloseButton();
		return true
	} catch (t) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onMeetingFull", coffeeTable.error);
		return false
	}
}
function sendOffer(e, t) {
	try {
		if (!e.peerConnection)
			throw "Invalid participant peer connection.";
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (coffeeTable.meeting.id === undefined
				|| coffeeTable.meeting.id === null
				|| coffeeTable.meeting.id === "")
			throw "Meeting Id not defined.";
		if (e.id === undefined || e.id === null || e.id === "")
			throw "Participant Id not defined.";
		if (coffeeTable.bandwidth === undefined
				|| coffeeTable.bandwidth === null
				|| coffeeTable.bandwidth === "")
			throw "Bandwidth not defined.";
		t = getSDP(t);
		e.peerConnection.setLocalDescription(t, onSetSessionDescriptionSuccess,
				onSetSessionDescriptionError);
		if (true === coffeeTable.user.videoMuted) {
			toggleVideoTrack(false)
		}
		if (!sendCommand({
			meetingId : coffeeTable.meeting.id,
			type : t.type,
			fromParticipantId : coffeeTable.user.id,
			toParticipantId : e.id,
			isScreenSharingOffer : coffeeTable.screenSharing,
			sdp : t.sdp,
			bandwidth : coffeeTable.bandwidth,
			audioMuted : coffeeTable.user.audioMuted,
			videoMuted : coffeeTable.user.videoMuted,
			service : coffeeTable.service
		}))
			throw "Could not set local description and could not send offer command to the server.";
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("sendOffer", coffeeTable.error);
		return false
	}
}
function onOffer(e) {
	try {
		if (undefined !== e.error && "true" === e.error) {
			endCoffeeTable();
			sendParticipantOffline();
			throw e.errorMessage
		}
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.fromParticipantId === undefined || e.fromParticipantId === "")
			throw "Invalid Participant Id.";
		if (e.toParticipantId === undefined || e.toParticipantId === ""
				|| e.toParticipantId !== coffeeTable.user.id)
			throw "Invalid user Id.";
		if (e.sdp === undefined)
			throw "SDP not defined.";
		if (e.bandwidth === undefined)
			throw "Bandwidth not defined.";
		if (e.isScreenSharingOffer === undefined)
			throw "Screen sharing flag not defined.";
		coffeeTable.meeting.id = e.meetingId;
		var t = null;
		if (!coffeeTable.screenSharing) {
			t = getParticipantByParticipantId(e.fromParticipantId);
			if (!t) {
				throw "Invalid Participant Id."
			}
		} else if (coffeeTable.screenSharing) {
			t = getParticipantByParticipantId(e.fromParticipantId + "Screen");
			if (!t) {
				throw "Invalid Participant Id."
			}
		}
		t.offer = e;
		t.videoMuted = e.videoMuted;
		t.audioMuted = e.audioMuted;
		if (true === coffeeTable.user.videoMuted) {
			toggleVideoTrack(true)
		}
		if (!createNewAnswer(t))
			throw "Could not create the answer for the participant.";
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onOffer", coffeeTable.error);
		return false
	}
}
function sendAnswer(e, t) {
	try {
		if (true === coffeeTable.user.videoMuted) {
			toggleVideoTrack(false)
		}
		if (!e.peerConnection)
			throw "Invalid participant peer connection.";
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (coffeeTable.meeting.id === undefined
				|| coffeeTable.meeting.id === null
				|| coffeeTable.meeting.id === "")
			throw "Meeting Id not defined.";
		if (e.id === undefined || e.id === null || e.id === "")
			throw "Participant Id not defined.";
		if (coffeeTable.bandwidth === undefined
				|| coffeeTable.bandwidth === null
				|| coffeeTable.bandwidth === "")
			throw "Bandwidth not defined.";
		t = getSDP(t);
		e.peerConnection.setLocalDescription(t, onSetSessionDescriptionSuccess,
				onSetSessionDescriptionError);
		var n = null;
		if (coffeeTable.screenSharing) {
			n = e.id.replace("Screen", "")
		} else {
			n = e.id
		}
		if (!sendCommand({
			meetingId : coffeeTable.meeting.id,
			type : t.type,
			fromParticipantId : coffeeTable.user.id,
			toParticipantId : n,
			sdp : t.sdp,
			audioMuted : coffeeTable.user.audioMuted,
			videoMuted : coffeeTable.user.videoMuted,
			bandwidth : coffeeTable.bandwidth,
			service : coffeeTable.service
		}))
			throw "Could not set local description and could not send answer command to the server.";
		return true
	} catch (r) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = r;
		errorHandler("sendAnswer", coffeeTable.error);
		return false
	}
}
function onAnswer(e) {
	try {
		if (undefined !== e.error && "true" === e.error) {
			endCoffeeTable();
			sendParticipantOffline();
			throw e.errorMessage
		}
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.fromParticipantId === undefined || e.fromParticipantId === "")
			throw "Invalid Participant Id.";
		if (e.toParticipantId === undefined || e.toParticipantId === ""
				|| e.toParticipantId !== coffeeTable.user.id)
			throw "Invalid user Id.";
		if (e.sdp === undefined)
			throw "SDP not defined.";
		if (e.bandwidth === undefined)
			throw "Bandwidth not defined.";
		var t = null;
		if (coffeeTable.screenSharing) {
			t = e.fromParticipantId.replace("Screen", "")
		} else {
			t = e.fromParticipantId
		}
		var n = getParticipantByParticipantId(t);
		if (!n) {
			throw "Invalid Participant Id."
		}
		n.videoMuted = e.videoMuted;
		n.audioMuted = e.audioMuted;
		if ("instantCall" === coffeeTable.service)
			showParticipant(n);
		hideParticipantMessage(n);
		n.peerConnection.setRemoteDescription(getRemoteDescription(e),
				onSetSessionDescriptionSuccess, onSetSessionDescriptionError);
		n.isRemoteDescSet = true;
		while (n.iceCandidates.length > 0) {
			onIceCandidate(n.iceCandidates.shift())
		}
		n.iceServerType = getIceCandidateType(e.sdp);
		return true
	} catch (r) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = r;
		errorHandler("onAnswer", coffeeTable.error);
		return false
	}
}
function sendIceCandidates(e, t) {
	try {
		if (!e || !e.peerConnection || !t || !t.candidate)
			return;
		var n = null;
		if (coffeeTable.screenSharing) {
			n = e.id.replace("Screen", "")
		} else {
			n = e.id
		}
		if (t.candidate) {
			if (e.id === undefined || e.id === null || e.id === "")
				throw "Participant Id not defined.";
			if (!sendCommand({
				meetingId : coffeeTable.meeting.id,
				fromParticipantId : coffeeTable.user.id,
				toParticipantId : n,
				label : t.candidate.sdpMLineIndex,
				id : t.candidate.sdpMid,
				candidate : t.candidate.candidate,
				type : "candidate",
				service : coffeeTable.service
			}))
				throw "Could not send ice candidate command to the server."
		}
		return true
	} catch (r) {
		coffeeTable.code = "VC103";
		coffeeTable.detailedMessage = r;
		errorHandler("sendIceCandidates", coffeeTable.error);
		return false
	}
}
function onIceCandidate(e) {
	try {
		if (undefined !== e.error && "true" === e.error) {
			endCoffeeTable();
			sendParticipantOffline();
			throw e.errorMessage
		}
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.fromParticipantId === undefined || e.fromParticipantId === "")
			throw "Invalid Participant Id.";
		if (e.toParticipantId === undefined || e.toParticipantId === ""
				|| e.toParticipantId !== coffeeTable.user.id)
			throw "Invalid user Id.";
		if (e.label === undefined)
			throw "Label not defined.";
		if (e.id === undefined)
			throw "Id not defined.";
		if (e.candidate === undefined)
			throw "Candidate not defined.";
		var t = null;
		if (coffeeTable.screenSharing) {
			t = e.fromParticipantId.replace("Screen", "")
		} else {
			t = e.fromParticipantId
		}
		var n = getParticipantByParticipantId(t);
		if (!n) {
			throw "Invalid Participant Id."
		}
		if (!n.isRemoteDescSet)
			n.iceCandidates.push(e);
		else
			n.peerConnection.addIceCandidate(getIceCandidate(e));
		n.iceServerType = getIceCandidateType(e.candidate);
		return true
	} catch (r) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = r;
		errorHandler("onIceCandidate", coffeeTable.error);
		return false
	}
}
function sendCallStarted(e) {
	try {
		if (e === undefined || e === null || e === "")
			throw "Participant not defined.";
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (e.iceServerType === undefined || e.iceServerType === null
				|| e.iceServerType === "")
			throw "Ice Server Type not defined.";
		if (true === coffeeTable.isReady) {
			if (!sendCommand({
				type : "meetingStarted",
				meetingId : coffeeTable.meeting.id,
				userId : coffeeTable.user.id,
				iceServerType : e.iceServerType,
				timeStamp : $.now(),
				service : coffeeTable.service
			}))
				throw "Could not send call started command to the server."
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		logError("sendCallStarted", coffeeTable.error);
		return false
	}
}
function sendSync(e) {
	try {
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (e === undefined || e === null || e === "")
			throw "Sync Type not defined.";
		if (!sendCommand({
			type : "sync",
			meetingId : coffeeTable.meeting.id,
			syncType : e,
			bandwidth : coffeeTable.bandwidth,
			participantId : coffeeTable.user.id,
			service : coffeeTable.service
		}))
			throw "Could not send sync command to the server.";
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		logError("sendSync", coffeeTable.error);
		return false
	}
}
function onSync(e) {
	try {
		if (undefined !== e.error && "true" === e.error) {
			showServerError(e, "main");
			return true
		} else if (e.syncType === "lowBandwidth")
			onLowBandwidth(e);
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		logError("onSync", coffeeTable.error);
		return false
	}
}
function onLowBandwidth(e) {
	try {
		if (e.meetingId === undefined)
			throw "Meeting id not defined.";
		if (e.participantId === undefined)
			throw "Participant id not defined.";
		if (e.bandwidth === undefined)
			throw "Bandwidth not defined.";
		coffeeTable.bandwidth = e.bandwidth;
		var t = getParticipantByParticipantId(e.participantId);
		if (!t) {
			throw "Invalid Participant Id."
		}
		if (true === coffeeTable.user.videoMuted) {
			toggleVideoTrack(true)
		}
		if (!createNewOffer(t))
			throw "Could not create the offer for the participant.";
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onLowBandwidth", coffeeTable.error);
		return false
	}
}
function sendNoAnswer() {
	try {
		endOffer();
		restoreTitle();
		stopRinging();
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (coffeeTable.meeting.id === undefined
				|| coffeeTable.meeting.id === null
				|| coffeeTable.meeting.id === "")
			throw "Peer Participant Id not defined.";
		if (!sendCommand({
			participantId : coffeeTable.user.id,
			meetingId : coffeeTable.meeting.id,
			type : "noAnswer",
			service : coffeeTable.service
		}))
			throw "Could not send no answer command to the server.";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("sendNoAnswer", coffeeTable.error);
		return false
	}
}
function sendReject() {
	try {
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (coffeeTable.meeting.id === undefined
				|| coffeeTable.meeting.id === null
				|| coffeeTable.meeting.id === "")
			throw "Meeting Id not defined.";
		if (!sendCommand({
			participantId : coffeeTable.user.id,
			meetingId : coffeeTable.meeting.id,
			type : "reject",
			service : coffeeTable.service
		}))
			throw "Could not send reject command to the server.";
		return true;
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		errorHandler("sendReject", coffeeTable.error);
		return false
	}
}
function onBusy(e) {
	try {
		if (e.toParticipantId === undefined)
			throw "Participant Id not defined.";
		if (e.meetingId === undefined)
			throw "Meeting Id not defined.";
		var t = getParticipantByParticipantId(e.toParticipantId);
		if (!t) {
			throw "Invalid Participant Id."
		}
		if ("noAnswer" === e.type) {
			showUserMessage(t.name + " not reachable.")
		} else {
			showUserMessage(t.name + " is busy.")
		}
		makeParticipantOffline(t);
		if (coffeeTable.initiator) {
			stopRinging();
			playDisconnect()
		}
		if (coffeeTable.meeting.participantCount === 1) {
			coffeeTable.peer.id = t.id.toLowerCase();
			coffeeTable.peer.name = t.name;
			coffeeTable.peer.emailId = t.emailAddress.toLowerCase();
			setButtonState(mrCallButton, "enabled", "Call");
			setButtonState(mrEndButton, "enabled", "End");
			disableAllToggleButtons();
			resetCoffeeTableFlags()
		} else {
			hideParticipant(t);
			coffeeTable.meeting.participantCount--;
			coffeeTable.meeting.participants.splice(getParticipantIndex(t.id),
					1);
			coffeeTable.meeting.participants[0].messageContainer.fadeOut(15e3)
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onBusy", coffeeTable.error);
		return false
	}
}
function onIncoming(e) {
	try {
		clearTimeout(coffeeTable.trackers.timeout);
		releaseLocalMedia();
		stopRinging();
		showMessageBox(coffeeTableAppName + " Meetings",
				"Incoming Call. Please try after sometime.", "", true);
		showMessageBoxCloseButton();
		resetCoffeeTableFlags();
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onIncoming", coffeeTable.error);
		return false
	}
}
function endOffer() {
	try {
		clearTimeout(coffeeTable.trackers.timeout);
		hideMessageBox();
		resetCoffeeTableFlags();
		clearAllParticipantTimeOuts();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC109";
		coffeeTable.error.detailedMessage = e;
		errorHandler("endOffer", coffeeTable.error);
		return false
	}
}
function endCoffeeTable() {
	try {
		clearTimeout(coffeeTable.trackers.timeout);
		if (false === coffeeTable.isError)
			resetMessageBox();
		mrMeetingDetailsButton.unbind("mouseover mouseout");
		if ("instantCall" === coffeeTable.service) {
			releaseLocalMedia();
			stopRinging();
			userVideo.hide();
			hideInstantCallMeetingRoom();
			ctDock.hide();
			setButtonState(mrCallButton, "disabled", "Call");
			setButtonState(mrEndButton, "disabled", "End");
			mrEndButton.unbind("click")
		}
		hideRemoteVideos();
		disableAllToggleButtons();
		resetCoffeeTableFlags();
		clearAllParticipantTimeOuts();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = e;
		logError("endCoffeeTable", coffeeTable.error);
		return false
	}
}
function sendQuit(e) {
	try {
		if (false === coffeeTable.isReady)
			return true;
		if (!sendCommand({
			type : "quit",
			service : e
		}))
			throw "Could not send quit command.";
		return true
	} catch (t) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = t;
		errorHandler("sendQuit", coffeeTable.error);
		return false
	}
}
function resetCoffeeTableFlags() {
	try {
		coffeeTable.dialing = false;
		coffeeTable.onCall = false;
		coffeeTable.initiator = false;
		coffeeTable.meetingStarted = false;
		coffeeTable.bandwidth = "default";
		coffeeTable.screenSharing = false;
		coffeeTable.meeting.participantCount = 0;
		coffeeTable.meeting.participants = [];
		coffeeTable.participants = [];
		if ("instantCall" === coffeeTable.service)
			meetingRoom.removeClass("meeting-room").addClass(
					"instant-call-window");
		return true
	} catch (e) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = e;
		logError("resetCoffeeTableFlags", coffeeTable.error);
		return false
	}
}
function getUserErrorMessage(e) {
	try {
		switch (e.code) {
		case "VC100":
			e.message = e.code
					+ " : Your web \n                    browser does not support Video Calling.";
			e.solution = "";
			break;
		case "VC101":
			e.message = e.code
					+ " : Sorry,\n                     we could not establish a connection with the Video Calling Server.";
			e.solution = "<li>Please contact your system administrator.</li>";
			break;
		case "VC102":
			e.message = e.code
					+ " : Sorry, \n                    but we do not have the permission to access your webcam or microphone.\n                    Please contact your system admin for assistance.";
			e.solution = "<li>1. Enable your browser to access to \n                    your webcam or video camera. </li>\n                    <li>2. Please contact your system administrator.</li>";
			break;
		case "VC103":
			e.message = e.code
					+ " : Error while\n                    communicating with the server. Message sending/receiving failed.";
			e.solution = "<li>1. Wait for some time and try to call again.</li>\n                    <li>2. If the problem persists, contact your system administrator.</li>";
			break;
		case "VC104":
			e.message = e.code
					+ " : Could not \n                    get the Paticipant Video. Please set up a new meeting/video call.";
			e.solution = "<li>1. Ask the other user to check his \n                    webcam settings. And try to call again. </li><li>2. If the problem persists, \n                    contact your system administrator. </li>";
			break;
		case "VC105":
		case "VC106":
		case "VC107":
			e.message = e.code
					+ " : Error initializing \n                    the "
					+ coffeeTableAppName + " video calling client.";
			e.solution = "<li>1. Refresh your page and try calling \n                    again.</li> <li>2. If the problem persists, contact your system administrator. </li>";
			break;
		case "VC108":
		case "VC109":
			e.message = e.code
					+ " : Sorry we \n                    could not establish the video connection. Please try after sometime.";
			e.solution = "<li>1. Please wait for sometime and set up a new meeting or call \n                    again.</li> <li>2. Refresh your page and try again.</li> <li>3. If the \n                    problem persists, contact your system administrator.</li> ";
			break
		}
		return e
	} catch (t) {
		logError("getUserErrorMessage", coffeeTable.error);
		return false
	}
}
function errorHandler(e, t) {
	try {
		clearInterval(coffeeTable.trackers.heartBeat);
		clearInterval(coffeeTable.trackers.serverHeartBeat);
		clearTimeout(coffeeTable.trackers.timeout);
		resetMessageBox();
		releaseLocalMedia();
		if (null !== coffeeTable.meeting.id)
			sendParticipantOffline();
		if (!coffeeTable.isError) {
			userVideo.hide();
			hideRemoteVideos();
			disableAllToggleButtons();
			resetCoffeeTableFlags();
			stopRinging()
		}
		t = getUserErrorMessage(t);
		if ("Internet Explorer" === getCoffeeTableBrowserName()) {
			messageBoxOffsetX = 500;
			messageBoxOffsetY = 100
		}
		showErrorMessageBox(coffeeTableAppName + " Meeting Room Error", t);
		logError(e, t);
		if (null !== coffeeTable.user.videoStream)
			coffeeTable.user.videoStream.stop();
		if (null !== coffeeTable.user.videoElement)
			coffeeTable.user.videoElement.src = "";
		return true
	} catch (n) {
		logError("errorHandler : Could not log the error. Error : ",
				coffeeTable.error);
		return false
	}
}
function logError(e, t) {
	try {
		var n = e + " : [" + t.code + "] " + t.detailedMessage;
		if (coffeeTable.socket.conn !== null && true === coffeeTable.isReady) {
			sendCommand({
				type : "logClientError",
				errorMessage : n,
				service : coffeeTable.service
			})
		}
		logger("Error : " + n);
		return true
	} catch (r) {
		logger("Could not log the error on the server.", coffeeTable.error);
		return false
	}
}
function logger(e) {
	try {
		switch (coffeeTable.browserName) {
		case "Internet Explorer":
			return true;
		case "Chrome":
		case "Firefox":
			console.log(e);
			break
		}
		return true
	} catch (t) {
		return false
	}
}
function showParticipant(e) {
	try {
		hideParticipantVideo(e);
		hideParticipantMessage(e);
		if (true === coffeeTable.initiator) {
			initRemoveParticipant(e);
			if ("meeting" === coffeeTable.service)
				mrMoreChoices.show()
		}
		showParticipantName(e);
		showParticipantVideoContainer(e);
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		errorHandler("showParticipant", coffeeTable.error);
		return false
	}
}
function hideParticipant(e) {
	try {
		hideParticipantVideo(e);
		hideParticipantVideoContainer(e);
		hideParticipantMessage(e);
		e.removeButtonContainer.hide();
		hideParticipantName(e);
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("hideParticipant", coffeeTable.error);
		return false
	}
}
function showParticipantVideoContainer(e) {
	try {
		e.videoContainer.show().unbind("mouseover mouseout");
		e.videoContainer.bind("mouseover", function(t) {
			t.preventDefault();
			showParticipantName(e)
		});
		e.videoContainer.bind("mouseout", function(t) {
			t.preventDefault();
			hideParticipantName(e)
		});
		if ("participant-video-container coffee-table-hide" === e.videoContainer
				.attr("class")
				|| "participant-video-container hide" === e.videoContainer
						.attr("class")) {
			e.videoContainer.unbind("click").bind("click", function(t) {
				t.preventDefault();
				if (e.isOnline === true) {
					swapVideoSources(e, coffeeTable.meeting.participants[0]);
					swapParticipantToMainVideo(e)
				}
			})
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		errorHandler("showParticipantVideoContainer", coffeeTable.error);
		return false
	}
}
function swapVideoSources(e, t) {
	try {
		var n;
		if (window.webkitURL) {
			n = t.videoSrc.src;
			t.videoSrc.src = e.videoSrc.src;
			e.videoSrc.src = n
		} else {
			n = t.videoSrc.mozSrcObject;
			t.videoSrc.mozSrcObject = e.videoSrc.mozSrcObject;
			e.videoSrc.mozSrcObject = n
		}
		return true
	} catch (r) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = r;
		errorHandler("swapVideoSources", coffeeTable.error);
		return false
	}
}
function hideParticipantVideoContainer(e) {
	try {
		e.videoContainer.hide();
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("hideParticipantVideoContainer", coffeeTable.error);
		return false
	}
}
function showParticipantVideo(e) {
	try {
		if (e.isOnline) {
			e.video.show()
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("showParticipantVideo", coffeeTable.error);
		return false
	}
}
function hideParticipantVideo(e) {
	try {
		e.video.hide();
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("hideParticipantVideo", coffeeTable.error);
		return false
	}
}
function showParticipantName(e) {
	try {
		e.nameContainer.html(e.name).show();
		if (true === coffeeTable.initiator) {
			e.removeButtonContainer.show()
		} else if (e.removeButtonContainer.is(":visible")) {
			e.removeButtonContainer.hide()
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("showParticipantName", coffeeTable.error);
		return false
	}
}
function hideParticipantName(e) {
	try {
		if (e.isOnline === true && coffeeTable.meetingStarted && !e.videoMuted) {
			e.nameContainer.hide()
		}
		if (e.isOnline === true && coffeeTable.meetingStarted
				&& true === coffeeTable.initiator) {
			e.removeButtonContainer.hide()
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("hideParticipantName", coffeeTable.error);
		return false
	}
}
function showUserMessage(e, t) {
	try {
		if (undefined === e)
			return true;
		if ("" !== e)
			participantMessages[1].html(e).show();
		if (undefined !== t) {
			participantMessages[1].delay(5e3).fadeOut("fast")
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = n;
		logError("showParticipantMessage", coffeeTable.error);
		return false
	}
}
function showParticipantMessage(e, t, n) {
	try {
		if (undefined === t)
			return true;
		if ("" !== t)
			e.messageContainer.html(t).show();
		if (undefined !== n) {
			e.messageContainer.delay(5e3).fadeOut("fast")
		}
		return true
	} catch (r) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = r;
		logError("showParticipantMessage", coffeeTable.error);
		return false
	}
}
function hideParticipantMessage(e) {
	e.messageContainer.html("").hide()
}
function swapParticipantToMainVideo(e) {
	try {
		hideParticipantName(e);
		hideParticipantMessage(e);
		hideParticipantVideo(e);
		hideParticipantName(coffeeTable.meeting.participants[0]);
		hideParticipantMessage(coffeeTable.meeting.participants[0]);
		hideParticipantVideo(coffeeTable.meeting.participants[0]);
		tempParticipantPosition = e.position;
		e.position = coffeeTable.meeting.participants[0].position;
		coffeeTable.meeting.participants[0].position = tempParticipantPosition;
		tempMainParticipant = coffeeTable.meeting.participants[0];
		var t = getParticipantIndex(e.id);
		if (false === t)
			throw "Invalid Participant Id.";
		coffeeTable.meeting.participants[0] = e;
		coffeeTable.meeting.participants[t] = tempMainParticipant;
		coffeeTable.meeting.participants[0].videoContainer = participantVideoContainers[e.position];
		coffeeTable.meeting.participants[0].video = participantVideos[e.position];
		coffeeTable.meeting.participants[0].removeButtonContainer = participantRemoveButtonContainers[e.position];
		coffeeTable.meeting.participants[0].removeButton = participantRemoveButtons[e.position];
		coffeeTable.meeting.participants[0].nameContainer = participantNames[e.position];
		coffeeTable.meeting.participants[0].messageContainer = participantMessages[e.position];
		e.videoSrc = document.getElementById("participantVideo" + e.position);
		coffeeTable.meeting.participants[t].videoContainer = participantVideoContainers[tempParticipantPosition];
		coffeeTable.meeting.participants[t].video = participantVideos[tempParticipantPosition];
		coffeeTable.meeting.participants[t].removeButtonContainer = participantRemoveButtonContainers[tempParticipantPosition];
		coffeeTable.meeting.participants[t].removeButton = participantRemoveButtons[tempParticipantPosition];
		coffeeTable.meeting.participants[t].nameContainer = participantNames[tempParticipantPosition];
		coffeeTable.meeting.participants[t].messageContainer = participantMessages[tempParticipantPosition];
		coffeeTable.meeting.participants[t].videoSrc = document
				.getElementById("participantVideo" + tempParticipantPosition);
		showParticipantName(coffeeTable.meeting.participants[t]);
		showParticipantName(coffeeTable.meeting.participants[0]);
		if (coffeeTable.meeting.participants[t].videoMuted) {
			hideParticipantVideo(coffeeTable.meeting.participants[t]);
			showParticipantName(coffeeTable.meeting.participants[t]);
			showParticipantMessage(coffeeTable.meeting.participants[t],
					"Video turned off")
		} else {
			hideParticipantName(coffeeTable.meeting.participants[t]);
			showParticipantVideo(coffeeTable.meeting.participants[t])
		}
		if (coffeeTable.meeting.participants[0].videoMuted) {
			hideParticipantVideo(coffeeTable.meeting.participants[0]);
			showParticipantName(coffeeTable.meeting.participants[0]);
			showParticipantMessage(coffeeTable.meeting.participants[0],
					coffeeTable.meeting.participants[0].name
							+ " turned off the video")
		} else {
			hideParticipantName(coffeeTable.meeting.participants[0]);
			showParticipantVideo(coffeeTable.meeting.participants[0])
		}
		if (coffeeTable.meeting.participants[t].audioMuted) {
			coffeeTable.meeting.participants[t].videoSrc.mute = true;
			showParticipantMessage(coffeeTable.meeting.participants[t],
					"Audio muted")
		} else {
			coffeeTable.meeting.participants[t].videoSrc.mute = false
		}
		if (coffeeTable.meeting.participants[0].audioMuted) {
			coffeeTable.meeting.participants[0].videoSrc.mute = true;
			showParticipantMessage(coffeeTable.meeting.participants[0],
					coffeeTable.meeting.participants[0].name
							+ " turned off audio")
		} else {
			coffeeTable.meeting.participants[0].videoSrc.mute = false
		}
		showParticipantVideoContainer(e);
		showParticipantVideoContainer(coffeeTable.meeting.participants[t]);
		if (true === coffeeTable.initiator) {
			initRemoveParticipant(e);
			initRemoveParticipant(coffeeTable.meeting.participants[t])
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = n;
		errorHandler("swapParticipantToMainVideo", coffeeTable.error);
		return false
	}
}
function hideRemoteVideos() {
	try {
		for (index = 0; index < coffeeTable.meeting.participants.length; index++) {
			makeParticipantOffline(coffeeTable.meeting.participants[index]);
			if (coffeeTable.service === "instantCall" && index !== 0)
				hideParticipant(coffeeTable.meeting.participants[index]);
			hideParticipantMessage(coffeeTable.meeting.participants[index])
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("hideRemoteVideos", coffeeTable.error);
		return false
	}
}
function getNewParticipant(e) {
	try {
		var t = new Object;
		t.id = e.userId.toLowerCase();
		t.position = getParticipantEmptyPosition();
		++coffeeTable.meeting.participantCount;
		if (1 === parseInt(e.priority))
			t.isInitiator = true;
		else
			t.isInitiator = false;
		t.isOnline = e.online;
		t.name = e.name;
		t.emailAddress = e.emailId.toLowerCase();
		t.peerConnection = null;
		t.isRemoteDescSet = false;
		t.iceCandidates = [];
		t.iceServerType = null;
		t.offer = null;
		t.processIceCandidate = function(e) {
			sendIceCandidates(this, e)
		};
		t.processAddStream = function(e) {
			onRemoteStreamAdded(this, e)
		};
		t.processOffer = function(e) {
			sendOffer(this, e)
		};
		t.processAnswer = function(e) {
			sendAnswer(this, e)
		};
		t.contraints = {
			mandatory : {
				OfferToReceiveAudio : true,
				OfferToReceiveVideo : true
			}
		};
		t.videoContainer = participantVideoContainers[t.position];
		t.video = participantVideos[t.position];
		t.removeButtonContainer = participantRemoveButtonContainers[t.position];
		t.removeButton = participantRemoveButtons[t.position];
		t.nameContainer = participantNames[t.position];
		t.messageContainer = participantMessages[t.position];
		t.videoSrc = document.getElementById("participantVideo" + t.position);
		t.audioMuted = false;
		t.videoMuted = false;
		t.trackers = new Object;
		t.trackers.iceCandidateCheckTimeOut = null;
		t.trackers.iceCandidateCheckingStateTimeOut = null;
		t.trackers.remoteStreamTimeOut = null;
		t.trackers.statInterval = null;
		return t
	} catch (n) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = n;
		errorHandler("getNewParticipant", coffeeTable.error);
		return false
	}
}
function getParticipantEmptyPosition() {
	try {
		var e = 1;
		for (index = 0; index < coffeeTable.meeting.participants.length; index++) {
			if (coffeeTable.meeting.participants[index].position === e) {
				e++;
				continue
			}
			break
		}
		return e
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		logError("getParticipantEmptyPosition", coffeeTable.error);
		return false
	}
}
function getParticipantIndex(e) {
	try {
		for (index = 0; index < coffeeTable.meeting.participants.length; index++) {
			if (e === coffeeTable.meeting.participants[index].id)
				return index
		}
		throw "Participant Index not found."
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		logError("getParticipantIndex", coffeeTable.error);
		return false
	}
}
function getOnlineParticipantCount() {
	var e = 0;
	for (index = 0; index < coffeeTable.meeting.participants.length; index++) {
		if (coffeeTable.meeting.participants[index].isOnline)
			e++
	}
	return e
}
function getParticipantByParticipantId(e) {
	index = getParticipantIndex(e);
	if (false === index)
		return false;
	return coffeeTable.meeting.participants[index]
}
function clearAllParticipantTimeOuts() {
	try {
		for (index = 0; index < coffeeTable.meeting.participants.length; index++) {
			clearTimeout(coffeeTable.meeting.participants[index].trackers.iceCandidateCheckTimeOut);
			clearTimeout(coffeeTable.meeting.participants[index].trackers.iceCandidateCheckingStateTimeOut);
			clearTimeout(coffeeTable.meeting.participants[index].trackers.remoteStreamTimeOut);
			clearInterval(coffeeTable.meeting.participants[index].trackers.statInterval)
		}
	} catch (e) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = e;
		logError("getParticipantIndex", coffeeTable.error);
		return false
	}
}
function clearParticipantTimeOuts(e) {
	try {
		clearTimeout(e.trackers.iceCandidateCheckTimeOut);
		clearTimeout(e.trackers.iceCandidateCheckingStateTimeOut);
		clearTimeout(e.trackers.remoteStreamTimeOut);
		clearInterval(e.trackers.statInterval)
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		logError("clearParticipantTimeOuts", coffeeTable.error);
		return false
	}
}
function getNewMainVideoParticipant(e) {
	try {
		for (index = 0; index < coffeeTable.meeting.participants.length; index++) {
			if ((coffeeTable.meeting.participants[index] !== undefined || coffeeTable.meeting.participants[index] !== null)
					&& coffeeTable.meeting.participants[index].id !== e.id) {
				return coffeeTable.meeting.participants[index]
			}
		}
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		logError("getNewMainVideoParticipant", coffeeTable.error);
		return false
	}
}
function addParticipantToMeetingRoom() {
	try {
		if (coffeeTable.meeting.participantCount >= MAX_PARTICIPANTS - 1) {
			showMessageBoxInfo("Meeting room is full. Cannot add more participants.");
			ctParticipants[1].attr("valid", false).addClass(
					coffeeTableErrorBoxClass);
			throw "Meeting room is full. Cannot add more participants."
		} else if (coffeeTable.meeting.participantCount < MAX_PARTICIPANTS
				&& ctParticipants[1].val().trim() !== ""
				&& validateEmailId(ctParticipants[1], ctParticipants[1].val())) {
			index = getParticipantIndex(ctParticipants[1].val().trim());
			if (false === index) {
				ctParticipants[1].attr("valid", true).removeClass(
						coffeeTableErrorBoxClass).addClass(
						"add-participant-text-box");
				hideMessageBoxInfo();
				disableMessageBoxFormElements();
				setButtonInWaitState(ctMessageBoxButton1);
				if (!sendAddParticipant(ctParticipants[1].val().trim()))
					throw "Could not send add participant command."
			} else {
				showMessageBoxInfo("Participant already exists. Please enter different email address.");
				ctParticipants[1].attr("valid", false).addClass(
						coffeeTableErrorBoxClass);
				throw "Participant already exists. Please enter different email address."
			}
		} else if (coffeeTable.meeting.participantCount < MAX_PARTICIPANTS
				&& ctParticipants[1].val().trim() === "") {
			showMessageBoxInfo("Participant email address cannot be left blank.");
			ctParticipants[1].attr("valid", false).addClass(
					coffeeTableErrorBoxClass);
			throw "Participant email address cannot be left blank."
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = e;
		logError("addParticipantToMeetingRoom", coffeeTable.error);
		return false
	}
}
function sendAddParticipant(e) {
	try {
		var t = "";
		if (ctMessageBoxMeetingMessage.is(":visible")
				&& "" !== $.trim(ctMessageBoxMeetingMessage.val())) {
			t = ctMessageBoxMeetingMessage.val()
		}
		var n = "";
		if ("" !== $.trim(ctTopic.val())) {
			n = ctTopic.val()
		}
		if (!sendCommand({
			userId : coffeeTable.user.id,
			meetingId : coffeeTable.meeting.id,
			type : "addParticipant",
			participant : {
				participantId : e,
				participantName : e,
				participantEmailId : e
			},
			isScreenSharing : coffeeTable.screenSharing,
			meetingTopic : n,
			meetingMessage : t,
			service : coffeeTable.service
		}))
			throw "Could not send add participant command to the server.";
		return true
	} catch (r) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = r;
		errorHandler("sendAddParticipant", coffeeTable.error);
		return false
	}
}
function onAddParticipant(e) {
	try {
		if (e.service === undefined)
			throw "Service not defined.";
		if (undefined !== e.error && "true" === e.error) {
			showServerError(e, "main");
			coffeeTable.dialing = false;
			return true
		}
		if (e.userId === undefined)
			throw "User id not defined.";
		if (e.meetingId === undefined)
			throw "Meeting Id not defined.";
		if (e.participant === undefined)
			throw "Participant not defined.";
		if (e.meeting === undefined)
			throw "Meeting not defined.";
		if (e.isScreenSharing === undefined)
			throw "Is screen sharing flag not defined.";
		coffeeTable.screenSharing = e.isScreenSharing;
		if (e.participant.userId !== coffeeTable.user.id) {
			hideAddParticipantsMessageBox();
			coffeeTable.meeting.participants
					.push(getNewParticipant(e.participant));
			var t = getParticipantByParticipantId(e.participant.userId);
			if (!t) {
				throw "Invalid Participant Id."
			}
			showParticipant(t);
			if (coffeeTable.initiator && "instantCall" === coffeeTable.service) {
				showParticipantMessage(t, "Dialing");
				startRinging()
			} else if ("meeting" === coffeeTable.service) {
				if (coffeeTable.initiator && !coffeeTable.screenSharing) {
					showMessageBox(coffeeTableAppName + " Meetings",
							"Participant added successfully.", "", true);
					showMessageBoxCloseButton();
					if (coffeeTable.waitingForParticipants) {
						onWaitForParticipants("add")
					}
				} else if (coffeeTable.initiator && coffeeTable.screenSharing
						&& location.protocol.trim() === "http:") {
					showMessageBox(coffeeTableAppName + " Meetings",
							"Screen sharing can only be run in https mode.",
							"", true);
					showMessageBoxCloseButton()
				} else if (coffeeTable.initiator && coffeeTable.screenSharing
						&& location.protocol.trim() === "https:") {
					initScreenSharing(t)
				}
			}
		} else if (e.participant.userId === coffeeTable.user.id) {
			coffeeTable.meeting.id = e.meeting.id;
			$.each(e.meeting.participants, function(e, t) {
				if (coffeeTable.user.id !== t.userId)
					coffeeTable.meeting.participants.push(getNewParticipant(t))
			});
			showCallMessageBox(
					coffeeTableAppName + " Instant Call",
					"<b>"
							+ e.userId
							+ "</b> invited\n                  you to join a video call.")
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onAddParticipant", coffeeTable.error);
		return false
	}
}
function onRemoveParticipant(e) {
	try {
		if (e.service === undefined)
			throw "Service not defined.";
		if (undefined !== e.error && "true" === e.error) {
			showServerError(e, "message");
			return true
		}
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onRemoveParticipant", coffeeTable.error);
		return false
	}
}
function sendRemoveParticipant(e) {
	try {
		disableMessageBoxFormElements();
		setButtonInWaitState(ctMessageBoxButton1);
		if (!sendCommand({
			userId : coffeeTable.user.id,
			meetingId : coffeeTable.meeting.id,
			type : "removeParticipant",
			participantId : e,
			service : coffeeTable.service
		}))
			throw "Could not send add participant command to the server.";
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("sendRemoveParticipant", coffeeTable.error);
		return false
	}
}
function makeParticipantOnline(e) {
	try {
		e.isOnline = true;
		return true
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		logError("makeParticipantOnline", coffeeTable.error);
		return false
	}
}
function makeParticipantOffline(e) {
	try {
		e.isOnline = false;
		e.isRemoteDescSet = false;
		e.audioMuted = false;
		e.videoMuted = false;
		e.videoContainer.unbind("mouseover mouseout");
		e.removeButtonContainer.hide();
		showParticipantName(e);
		hideParticipantVideo(e);
		if (null !== e.peerConnection) {
			e.peerConnection.close();
			delete e.peerConnection;
			e.peerConnection = null
		}
		clearParticipantTimeOuts(e);
		return true
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		logError("makeParticipantOffline", coffeeTable.error);
		return false
	}
}
function displayLocalVideo() {
	try {
		if (window.webkitURL)
			coffeeTable.user.videoElement.src = window.webkitURL
					.createObjectURL(coffeeTable.user.videoStream);
		else
			coffeeTable.user.videoElement.src = window.URL
					.createObjectURL(coffeeTable.user.videoStream);
		coffeeTable.user.audioMuted = false;
		coffeeTable.user.videoMuted = false;
		userVideoContainer.show();
		userVideo.show();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = e;
		errorHandler("displayLocalVideo", coffeeTable.error);
		return false
	}
}
function onChangeUserStatus() {
	try {
		if (loggedInUserId === undefined || loggedInUserId === null
				|| loggedInUserId === "")
			throw "User Id not defined.";
		if (oldStatus === undefined || oldStatus === null || oldStatus === "")
			throw "User's old status not defined.";
		if (onlstat === undefined || onlstat === null || onlstat === "")
			throw "User's new status not defined.";
		if ("videocall" === onlstat && "enabled" === szVideoChatStatus) {
			if (oldStatus !== onlstat) {
				initCoffeeTable(coffeeTable.customerId, coffeeTable.appId,
						"instantCall")
			} else
				logger("onChangeUserStatus iterated.")
		} else if (coffeeTable.isReady && onlstat !== "videocall") {
			endCoffeeTable();
			sendQuit("instantCall");
			clearTimeout(coffeeTable.trackers.timeout);
			coffeeTable.trackers.reconnectionTimeOut = 3e4;
			ctNotification.html("").hide()
		} else if (!coffeeTable.isReady && onlstat !== "videocall"
				&& undefined !== coffeeTable.isReady) {
			clearTimeout(coffeeTable.trackers.timeout);
			coffeeTable.trackers.reconnectionTimeOut = 3e4;
			ctNotification.html("").hide()
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		logError("onChangeUserStatus", coffeeTable.error);
		return false
	}
}
function sendParticipantOnline() {
	try {
		if (!coffeeTable.isReady) {
			logger("sendParticipantOnline : The system is not ready. Could not send the user status to the server.");
			return false
		}
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (true === coffeeTable.isReady) {
			if (!sendCommand({
				type : "participantOnline",
				meetingId : coffeeTable.meeting.id,
				participantId : coffeeTable.user.id,
				service : coffeeTable.service
			}))
				throw "Could not send participant online command to the server."
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		logError("sendParticipantOnline", coffeeTable.error);
		return false
	}
}
function sendParticipantOffline() {
	try {
		if (!coffeeTable.isReady) {
			logger("sendParticipantOffline : System not ready. Could not send the user status to the server.");
			return false
		}
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (true === coffeeTable.isReady) {
			if (!sendCommand({
				type : "participantOffline",
				meetingId : coffeeTable.meeting.id,
				participantId : coffeeTable.user.id,
				service : coffeeTable.service
			}))
				throw "Could not send participantOffline command to the server."
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = e;
		logError("participantOffline", coffeeTable.error);
		return false
	}
}
function onParticipantOnline(e) {
	try {
		if (undefined !== e.error && "true" === e.error) {
			endCoffeeTable();
			sendParticipantOffline();
			throw e.errorMessage
		}
		if ("instantCall" === coffeeTable.service)
			stopRinging();
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.participantId === undefined || e.participantId === "")
			throw "Invalid Participant Id.";
		clearInterval(coffeeTable.trackers.timeout);
		coffeeTable.trackers.initiatorOfflineTimeOut = coffeeTable.serverParameters.initiatorOfflineTimeOut;
		coffeeTable.waitingForParticipants = true;
		hideMessageBox();
		var t = getParticipantByParticipantId(e.participantId);
		if (!t) {
			throw "Invalid Participant Id."
		}
		makeParticipantOnline(t);
		showParticipantMessage(t, "Connecting...");
		if (true === coffeeTable.user.videoMuted) {
			toggleVideoTrack(true)
		}
		if (!createNewOffer(t))
			throw "Could not create offer for the participant.";
		return true
	} catch (n) {
		coffeeTable.isError = true;
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onParticipantOnline", coffeeTable.error);
		return false
	}
}
function onParticipantOffline(e) {
	try {
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.participantId === undefined || e.participantId === "")
			throw "Invalid Participant Id.";
		coffeeTable.dialing = false;
		if ("meeting" === coffeeTable.service) {
			handleParticpantOfflineForMeeting(e)
		} else if ("instantCall" === coffeeTable.service) {
			handleParticpantOfflineForInstantCall(e)
		} else {
			throw "Invalid service type."
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onParticipantOffline", coffeeTable.error);
		return false
	}
}
function handleParticpantOfflineForMeeting(e) {
	try {
		if (coffeeTable.user.id === e.participantId) {
			return true
		}
		var t = getParticipantByParticipantId(e.participantId);
		if (!t) {
			throw "Invalid Participant Id."
		}
		makeParticipantOffline(t);
		if (e.removeParticipant !== undefined) {
			coffeeTable.meeting.participantCount--;
			if (t.position === 1) {
				newMainVideoParticipant = getNewMainVideoParticipant(t);
				if (false === newMainVideoParticipant)
					throw "New main video participant not found";
				swapVideoSources(t, newMainVideoParticipant);
				swapParticipantToMainVideo(newMainVideoParticipant)
			}
			hideParticipant(t);
			coffeeTable.meeting.participants.splice(getParticipantIndex(t.id),
					1);
			hideRemoveParticipantMessageBox();
			if (coffeeTable.user.id === e.initiatorId) {
				showMessageBox(coffeeTableAppName + " Meetings",
						"Participant was removed successfully.", "", true);
				showMessageBoxCloseButton()
			}
		}
		if (e.meetingTimeOut === undefined && undefined === e.removeParticipant) {
			if (1 === t.position) {
				showParticipantMessage(t, t.name + " went offline", true)
			} else {
				showParticipantMessage(t, "User went offline", true)
			}
		}
		if (e.removeParticipant === undefined)
			showParticipantVideoContainer(t);
		if (e.waitForParticipants !== undefined) {
			hideMessageBoxCloseButton();
			onWaitForParticipants()
		} else if (coffeeTable.waitingForParticipants) {
			hideMessageBoxCloseButton();
			onWaitForParticipants("remove")
		} else if (e.meetingTimeOut !== undefined) {
			hideMessageBoxCloseButton();
			onWaitForInitiator(e)
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("handleParticpantOfflineForMeeting", coffeeTable.error);
		return false
	}
}
function handleParticpantOfflineForInstantCall(e) {
	try {
		if (!coffeeTable.meetingStarted && !coffeeTable.initiator) {
			restoreTitle();
			endOffer();
			return true
		}
		coffeeTable.meeting.participantCount--;
		if (e.removeParticipant && coffeeTable.user.id === e.participantId) {
			coffeeTable.onCall = false;
			endCoffeeTable();
			showMessageBox(coffeeTableAppName + " Meetings",
					"Video call ended, please close this window.");
			showMessageBoxCloseButton();
			return true
		}
		clearTimeout(coffeeTable.trackers.timeout);
		setButtonState(mrEndButton, "enabled", "End");
		bindCoffeeTableButtonEvents();
		stopRinging();
		playDisconnect();
		ctDock.hide();
		showInstantCallMeetingRoom();
		var t = getParticipantByParticipantId(e.participantId);
		if (!t) {
			throw "Invalid Participant Id."
		}
		if (coffeeTable.initiator && undefined !== e.removeParticipant) {
			showUserMessage("Participant was removed successfully.", true);
			showMessageBoxCloseButton()
		} else if (coffeeTable.initiator && undefined !== e.reject) {
			showUserMessage(t.name + " is busy.", true)
		} else if (coffeeTable.initiator && undefined !== e.noAnswer) {
			showUserMessage(t.name + " is not reachable.", true)
		} else {
			showUserMessage(t.name + " went offline.", true)
		}
		if (coffeeTable.meeting.participantCount === 0) {
			coffeeTable.peer.id = t.id.toLowerCase();
			coffeeTable.peer.name = t.name;
			coffeeTable.peer.emailId = t.emailAddress.toLowerCase();
			setButtonState(mrCallButton, "enabled", "Call");
			disableAllToggleButtons();
			resetCoffeeTableFlags()
		} else if (t.isInitiator) {
			hideRemoteVideos();
			disableAllToggleButtons();
			resetCoffeeTableFlags();
			showUserMessage(t.name
					+ " ended the call. Please click on end button to exit.");
			return true
		}
		if (t.position === 1 && coffeeTable.meeting.participantCount !== 0) {
			newMainVideoParticipant = getNewMainVideoParticipant(t);
			if (false === newMainVideoParticipant)
				throw "New main video participant not found";
			swapVideoSources(t, newMainVideoParticipant);
			swapParticipantToMainVideo(newMainVideoParticipant);
			hideParticipant(t)
		} else if (t.position !== 1) {
			hideParticipant(t)
		}
		makeParticipantOffline(t);
		coffeeTable.meeting.participants.splice(getParticipantIndex(t.id), 1);
		hideRemoveParticipantMessageBox();
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("handleParticpantOfflineForInstantCall", coffeeTable.error);
		return false
	}
}
function onWaitForInitiator(e) {
	try {
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.participantId === undefined)
			throw "Participant id not defined.";
		if (e.initiatorId === undefined)
			throw "Initiator id not defined.";
		disableAllToggleButtons();
		index = getParticipantIndex(e.initiatorId);
		if (false === index)
			throw "Invalid Participant Id.";
		if (undefined === e.meetingTimeOut)
			showMessageBox(coffeeTableAppName + " Meetings",
					"Meeting initiator is offline. Waiting for <b>"
							+ e.initiatorId + "</b> to come online.");
		else
			coffeeTable.trackers.timeout = setInterval(
					"showWaitingForInitiator('" + index + "')", 1e3);
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onWaitForInitiator", coffeeTable.error);
		return false
	}
}
function showWaitingForInitiator(e) {
	try {
		coffeeTable.trackers.initiatorOfflineTimeOut = coffeeTable.trackers.initiatorOfflineTimeOut - 1e3;
		var t = coffeeTable.meeting.participants[e];
		if (!t.isOnline)
			showMessageBox(
					coffeeTableAppName + " Meetings",
					"Initiator offline. Waiting for <b>"
							+ t.id
							+ "</b> to come online. </br></br> The meeting will end in "
							+ coffeeTable.trackers.initiatorOfflineTimeOut
							/ 1e3 + " seconds.", true, true);
		if (coffeeTable.trackers.initiatorOfflineTimeOut <= 0) {
			endCoffeeTable();
			coffeeTable.meetingEnded = true;
			clearInterval(coffeeTable.trackers.timeout);
			coffeeTable.trackers.initiatorOfflineTimeOut = coffeeTable.serverParameters.initiatorOfflineTimeOut;
			sendQuit("meeting")
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = n;
		errorHandler("showWaitingForInitiator", coffeeTable.error);
		return false
	}
}
function onWaitForParticipants(e) {
	try {
		showMessageBox(coffeeTableAppName + " Meetings",
				"Waiting for other participants to come online.");
		disableAllToggleButtons();
		coffeeTable.waitingForParticipants = true;
		mrMoreChoices.unbind("click").bind("click", function(e) {
			e.preventDefault();
			e.stopPropagation();
			toggleMoreChoicesMenu()
		});
		setButtonState(mrEndButton, "enabled", "Leave meeting room");
		setButtonState(mrMoreChoices, "enabled", "Click for more options");
		if (undefined !== e) {
			if ("add" === e) {
				showMessageBoxInfo("Participant added successfully.", true)
			} else if ("remove" === e) {
				showMessageBoxInfo("Participant was removed successfully.",
						true)
			}
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onWaitForParticipants", coffeeTable.error);
		return false
	}
}
function onInitiatorTimeOut(e) {
	try {
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.participantId === undefined)
			throw "Participant id not defined.";
		endCoffeeTable();
		coffeeTable.meetingEnded = true;
		sendQuit("meeting");
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onInitiatorTimeOut", coffeeTable.error);
		return false
	}
}
function getButtonState(e) {
	try {
		return e.attr("state")
	} catch (t) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = t;
		logError("getButtonState", coffeeTable.error);
		return false
	}
}
function setButtonState(e, t, n, r) {
	try {
		if (t === "enabled") {
			$(e.selector + "Icon").attr("class", "icon-enabled")
		} else if (t === "disabled") {
			$(e.selector + "Icon").attr("class", "icon-disabled")
		} else if (t === "activated") {
			$(e.selector + "Icon").attr("class", "icon-activated")
		}
		if (r !== undefined || r !== "") {
			$(e.selector + "Text").html(r)
		}
		if (n !== undefined) {
			e.attr("title", n)
		}
		e.attr("state", t);
		return true
	} catch (i) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = i;
		logError("setButtonState", coffeeTable.error);
		return false
	}
}
function enableAllToggleButtons() {
	mrAudioMuteButton.unbind("click").bind("click", function(e) {
		e.preventDefault();
		toggleAudioMute()
	});
	mrVideoMuteButton.unbind("click").bind("click", function(e) {
		e.preventDefault();
		toggleVideoMute()
	});
	mrLowBandwidthButton.unbind("click").bind("click", function(e) {
		e.preventDefault();
		toggleBandwidth()
	});
	mrEndButton.unbind("click").bind("click", function(e) {
		e.preventDefault();
		toggleEnd()
	});
	mrMoreChoices.unbind("click").bind("click", function(e) {
		e.preventDefault();
		e.stopPropagation();
		toggleMoreChoicesMenu()
	});
	if (coffeeTable.user.audioMuted) {
		setButtonState(mrAudioMuteButton, "activated", "Unmute your audio")
	} else {
		setButtonState(mrAudioMuteButton, "enabled", "Mute your audio")
	}
	if (coffeeTable.user.videoMuted) {
		setButtonState(mrVideoMuteButton, "activated",
				"Turn your video back on")
	} else {
		setButtonState(mrVideoMuteButton, "enabled", "Turn off your video")
	}
	if (coffeeTable.bandwidth === "low") {
		setButtonState(mrLowBandwidthButton, "activated",
				"Go back to a normal call")
	} else {
		setButtonState(mrLowBandwidthButton, "enabled",
				"Start a low bandwith call")
	}
	setButtonState(mrEndButton, "enabled", "Leave meeting room");
	setButtonState(mrMoreChoices, "enabled", "Click for more options")
}
function disableAllToggleButtons() {
	mrAudioMuteButton.unbind("click");
	mrVideoMuteButton.unbind("click");
	mrLowBandwidthButton.unbind("click");
	setButtonState(mrAudioMuteButton, "disabled", "Mute your audio");
	setButtonState(mrVideoMuteButton, "disabled", "Turn off your video");
	setButtonState(mrLowBandwidthButton, "disabled",
			"Start a low bandwith call");
	if ("meeting" === coffeeTable.service) {
		mrEndButton.unbind("click");
		mrMoreChoices.unbind("click");
		setButtonState(mrEndButton, "disabled", "Leave meeting room");
		setButtonState(mrMoreChoices, "disabled", "Click for more options")
	}
}
function toggleAudioMute() {
	try {
		if ("enabled" === getButtonState(mrAudioMuteButton)
				&& coffeeTable.meetingStarted && sendToggleMute("audioMute")) {
			coffeeTable.user.audioMuted = true;
			setButtonState(mrAudioMuteButton, "activated", "Unmute your audio")
		} else if ("activated" === getButtonState(mrAudioMuteButton)
				&& coffeeTable.meetingStarted && sendToggleMute("audioUnmute")) {
			coffeeTable.user.audioMuted = false;
			setButtonState(mrAudioMuteButton, "enabled", "Mute your audio")
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("toggleAudioMute", coffeeTable.error);
		return false
	}
}
function onToggleMute(e) {
	try {
		if (e.type === undefined || e.type === "")
			throw "Invalid Participant Id.";
		if (undefined !== e.error && "true" === e.error) {
			switch (e.type) {
			case "audioMute":
			case "audioUnmute":
				showUserMessage("Error sending audio mute/unmute to particiants. Please end this call and make again.");
				break;
			case "videoMute":
			case "videoUnmute":
				showUserMessage("Error sending video on/off to particiants. Please end this call and make again.");
				break
			}
			return false
		}
		if (e.meetingId === undefined || e.meetingId !== coffeeTable.meeting.id)
			throw "Invalid meeting id.";
		if (e.participantId === undefined || e.participantId === "")
			throw "Invalid Participant Id.";
		var t = getParticipantByParticipantId(e.participantId);
		if (!t) {
			throw "Invalid Participant Id."
		}
		switch (e.type) {
		case "audioMute":
			handleAudioMute(t);
			break;
		case "audioUnmute":
			handleAudioUnmute(t);
			break;
		case "videoMute":
			handleVideoMute(t);
			break;
		case "videoUnmute":
			handleVideoUnmute(t);
			break
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onToggleMute", coffeeTable.error);
		return false
	}
}
function handleAudioMute(e) {
	try {
		e.videoSrc.muted = true;
		if (1 === e.position) {
			showParticipantMessage(e, e.name + " turned off audio")
		} else {
			showParticipantMessage(e, "Audio muted")
		}
		e.audioMuted = true;
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("handle", coffeeTable.error);
		return false
	}
}
function handleAudioUnmute(e) {
	try {
		e.videoSrc.muted = false;
		hideParticipantMessage(e);
		e.audioMuted = false;
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("haandleAudioUnmute", coffeeTable.error);
		return false
	}
}
function sendToggleMute(e) {
	try {
		if (coffeeTable.meeting.id === undefined
				|| coffeeTable.meeting.id === null
				|| coffeeTable.meeting.id === "")
			throw "Meeting Id not defined.";
		if (coffeeTable.user.id === undefined || coffeeTable.user.id === null
				|| coffeeTable.user.id === "")
			throw "User Id not defined.";
		if (e === undefined || e === null || e === "")
			throw "Tyoe of command not defined.";
		if (!sendCommand({
			meetingId : coffeeTable.meeting.id,
			participantId : coffeeTable.user.id,
			type : e,
			service : coffeeTable.service
		}))
			throw "Could not send toggle unmute command to the server.";
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("sendToggleMute", coffeeTable.error);
		return false
	}
}
function toggleVideoTrack(e) {
	try {
		var t = coffeeTable.user.videoStream.getVideoTracks();
		if (t.length === 0)
			throw "Video track not found";
		if (e) {
			for (i = 0; i < t.length; i++)
				t[i].enabled = true
		} else {
			for (i = 0; i < t.length; i++)
				t[i].enabled = false
		}
		return true
	} catch (n) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = n;
		errorHandler("toggleVideoTrack", coffeeTable.error);
		return false
	}
}
function toggleVideoMute() {
	try {
		if ("enabled" === getButtonState(mrVideoMuteButton)
				&& coffeeTable.meetingStarted && toggleVideoTrack(false)
				&& sendToggleMute("videoMute")) {
			setButtonState(mrVideoMuteButton, "activated",
					"Turn your video back on");
			userVideo.hide();
			coffeeTable.user.videoMuted = true
		} else if ("activated" === getButtonState(mrVideoMuteButton)
				&& coffeeTable.meetingStarted && toggleVideoTrack(true)
				&& sendToggleMute("videoUnmute")) {
			setButtonState(mrVideoMuteButton, "enabled", "Turn off your video");
			userVideo.show();
			coffeeTable.user.videoMuted = false
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("toggleVideoMute", coffeeTable.error);
		return false
	}
}
function handleVideoMute(e) {
	try {
		hideParticipantVideo(e);
		if (1 === e.position) {
			showParticipantMessage(e, e.name + " turned off the video")
		} else {
			showParticipantMessage(e, "Video turned off")
		}
		e.videoMuted = true;
		showParticipantName(e);
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("handleVideoMute", coffeeTable.error);
		return false
	}
}
function handleVideoUnmute(e) {
	try {
		showParticipantVideo(e);
		hideParticipantMessage(e);
		e.videoMuted = false;
		return true
	} catch (t) {
		coffeeTable.error.code = "VC103";
		coffeeTable.error.detailedMessage = t;
		errorHandler("handleVideoUnmute", coffeeTable.error);
		return false
	}
}
function toggleBandwidth() {
	try {
		mrLowBandwidthButton.unbind("click");
		mrAudioMuteButton.unbind("click");
		setButtonState(mrAudioMuteButton, "disabled", "Mute your audio");
		mrVideoMuteButton.unbind("click");
		setButtonState(mrVideoMuteButton, "disabled", "Turn off your video");
		if ("enabled" === getButtonState(mrLowBandwidthButton)) {
			showUserMessage("Please wait. Re-initiating the call using less bandwidth.");
			coffeeTable.bandwidth = "low"
		} else if ("activated" === getButtonState(mrLowBandwidthButton)) {
			showUserMessage("Please wait. Re-initiating the call using higher bandwidth.");
			coffeeTable.bandwidth = "default"
		}
		if (coffeeTable.isReady) {
			setButtonState(mrLowBandwidthButton, "disabled",
					"Start a low bandwith call");
			sendSync("lowBandwidth")
		} else {
			endCoffeeTable();
			showMessageBox(coffeeTableAppName + " Meetings",
					"The system is not ready to make video calls. Please try after sometime.");
			showMessageBoxCloseButton()
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("toggleBandwidth", coffeeTable.error);
		return false
	}
}
function toggleEnd() {
	try {
		if ("instantCall" === coffeeTable.service) {
			endCoffeeTable();
			if (coffeeTable.socket !== null && coffeeTable.isReady)
				sendParticipantOffline()
		} else if ("meeting" === coffeeTable.service) {
			showMessageBox(coffeeTableAppName + " Meetings",
					"Would like to leave this room?");
			showMessageBoxButton1("Yes");
			ctMessageBoxButton1.unbind("click").bind("click", function(e) {
				e.preventDefault();
				endCoffeeTable();
				coffeeTable.meetingEnded = true;
				mrEndButton.unbind("click");
				setButtonState(mrEndButton, "disabled", "Left meeting room");
				clearInterval(coffeeTable.trackers.heartBeat);
				clearInterval(coffeeTable.trackers.serverHeartBeat);
				if (coffeeTable.socket !== null && coffeeTable.isReady)
					sendParticipantOffline()
			});
			showMessageBoxButton2("No");
			showMessageBoxCloseButton()
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC106";
		coffeeTable.error.detailedMessage = e;
		errorHandler("toggleEnd", coffeeTable.error);
		return false
	}
}
function bindCoffeeTableButtonEvents() {
	try {
		mrCallButton.unbind("click");
		mrCallButton
				.bind(
						"click",
						function(e) {
							e.preventDefault();
							if ("disabled" === getButtonState(mrCallButton))
								return;
							if (coffeeTable.isReady) {
								coffeeTable.participants = [
										{
											participantId : coffeeTable.user.id,
											participantName : coffeeTable.user.name,
											participantEmailId : coffeeTable.user.email
										},
										{
											participantId : coffeeTable.peer.id,
											participantName : coffeeTable.peer.name,
											participantEmailId : coffeeTable.peer.emailId
										} ];
								coffeeTable.initiator = true;
								coffeeTable.onCall = true;
								makeCall(true)
							} else {
								endCoffeeTable();
								showMessageBox(
										coffeeTableAppName + " Meetings",
										"Video calling system not available. Please try after sometime.");
								showMessageBoxCloseButton()
							}
						});
		mrFullScreen.unbind("click").bind(
				"click",
				function(e) {
					e.preventDefault();
					if ("enabled" === getButtonState(mrFullScreen)) {
						setButtonState(mrFullScreen, "activated");
						meetingRoom.removeClass("instant-call-window")
								.addClass("meeting-room");
						centerWindow(meetingRoom);
						$(window).unbind("resize");
						$(window).bind("resize", function() {
							if (!meetingRoom.is(":hidden"))
								centerWindow(meetingRoom)
						})
					} else if ("activated" === getButtonState(mrFullScreen)) {
						setButtonState(mrFullScreen, "enabled");
						showInstantCallMeetingRoom()
					}
				});
		mrMinimize.unbind("click").bind("click", function(e) {
			e.preventDefault();
			hideInstantCallMeetingRoom();
			ctDock.show()
		});
		ctDock.dblclick(function(e) {
			e.preventDefault();
			ctDock.hide();
			if ("enabled" === getButtonState(mrFullScreen))
				showInstantCallMeetingRoom();
			else if ("activated" === getButtonState(mrFullScreen)) {
				mrCallButton.show();
				meetingRoom.show()
			}
		});
		ctDockMaximize.unbind("click").bind("click", function(e) {
			e.preventDefault();
			ctDock.hide();
			if ("enabled" === getButtonState(mrFullScreen))
				showInstantCallMeetingRoom();
			else if ("activated" === getButtonState(mrFullScreen)) {
				mrCallButton.show();
				meetingRoom.show()
			}
		});
		mrEndButton.unbind("click").bind("click", function(e) {
			e.preventDefault();
			toggleEnd()
		});
		ctDockClose.unbind("click").bind("click", function(e) {
			e.preventDefault();
			toggleEnd()
		});
		mrNavigationContainer.dblclick(function(e) {
			e.preventDefault();
			hideInstantCallMeetingRoom();
			ctDock.show()
		});
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		errorHandler("bindInstantCallEvents : ", coffeeTable.error);
		return false
	}
}
function getNormalizedUserMedia() {
	try {
		return navigator.getUserMedia || navigator.webkitGetUserMedia
				|| navigator.mozGetUserMedia || navigator.msGetUserMedia
	} catch (e) {
		coffeeTable.error.code = "VC102";
		coffeeTable.error.detailedMessage = e;
		errorHandler("getNormalizedUserMedia : ", coffeeTable.error);
		return false
	}
}
function attachLocalMedia(e, t) {
	try {
		if ("Chrome" === coffeeTable.browserName) {
			showMessageBox(
					coffeeTableAppName + " Meetings",
					"To allow "
							+ coffeeTableAppName
							+ " to use the camera and the microphone, click on the Allow button appearing at the top of the browser.")
		} else if ("Firefox" === coffeeTable.browserName) {
			showMessageBox(
					coffeeTableAppName + " Meetings",
					"To share the camera and microphone with "
							+ coffeeTableAppName
							+ ", click on the Share Selected Devices on the browser pop-up.")
		}
		if (e === undefined) {
			e = true
		}
		if (t === undefined) {
			t = true
		}
		navigator.getUserMedia = getNormalizedUserMedia();
		navigator.getUserMedia({
			audio : {
				mandatory : {},
				optional : []
			},
			video : {
				mandatory : {},
				optional : []
			}
		}, onUserMediaSuccess, onUserMediaError);
		return true
	} catch (n) {
		coffeeTable.error.code = "VC102";
		coffeeTable.error.detailedMessage = n;
		errorHandler("attachLocalMedia", coffeeTable.error);
		return false
	}
}
function releaseLocalMedia() {
	try {
		if (null !== coffeeTable.user.videoStream)
			coffeeTable.user.videoStream.stop();
		if (null !== coffeeTable.user.videoElement)
			coffeeTable.user.videoElement.src = "";
		return true
	} catch (e) {
		coffeeTable.error.code = "VC102";
		coffeeTable.error.detailedMessage = e;
		errorHandler("releaseLocalMedia", coffeeTable.error);
		return false
	}
}
function onUserMediaSuccess(e) {
	try {
		hideMessageBox();
		coffeeTable.user.videoStream = e;
		if ("instantCall" === coffeeTable.service) {
			if (coffeeTable.initiator) {
				makeCall()
			} else if (!coffeeTable.initiator) {
				answerCall()
			}
		} else if ("meeting" === coffeeTable.service) {
			displayLocalVideo();
			showAuthenticationMessageBox(coffeeTableAppName + " Meetings",
					"Please select participant type and then enter your email address.")
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC102";
		coffeeTable.error.detailedMessage = t;
		errorHandler("onUserMediaSuccess", coffeeTable.error);
		return false
	}
}
function onUserMediaError(e) {
	try {
		throw "Could not access your webcam or microphone."
	} catch (e) {
		coffeeTable.error.code = "VC102";
		coffeeTable.error.detailedMessage = e;
		errorHandler("onUserMediaError", coffeeTable.error);
		return false
	}
}
function getNormalizedPeerConnection(e) {
	try {
		if (navigator.mozGetUserMedia) {
			return new mozRTCPeerConnection(e, coffeeTable.options)
		} else if (navigator.webkitGetUserMedia) {
			return new webkitRTCPeerConnection(e, coffeeTable.options)
		} else if (navigator.msGetUserMedia) {
			return new msRTCPeerConnection(e, coffeeTable.options)
		} else {
			return new RTCPeerConnection(e, coffeeTable.options)
		}
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		errorHandler("getNormalizedPeerConnection", coffeeTable.error);
		return false
	}
}
function getRemoteDescription(e) {
	try {
		switch (navigator.getUserMedia) {
		case navigator.mozGetUserMedia:
			return new mozRTCSessionDescription(e);
		default:
			return new RTCSessionDescription(e)
		}
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		errorHandler("getRemoteDescription", coffeeTable.error);
		return false
	}
}
function getIceCandidate(e) {
	try {
		switch (navigator.getUserMedia) {
		case navigator.mozGetUserMedia:
			return new mozRTCIceCandidate({
				sdpMLineIndex : e.label,
				candidate : e.candidate
			});
		default:
			return new RTCIceCandidate({
				sdpMLineIndex : e.label,
				candidate : e.candidate
			})
		}
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		errorHandler("getIceCandidate", coffeeTable.error);
		return false
	}
}
function getIceCandidateType(e) {
	try {
		if (e.indexOf("typ relay") >= 0)
			return "TURN";
		else if (e.indexOf("typ srflx") >= 0)
			return "STUN";
		else if (e.indexOf("typ host") >= 0)
			return "HOST";
		else
			throw "Cannot get Ice Candidate Type"
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		logError("getIceCandidateType", coffeeTable.error);
		return false
	}
}
function createPeerConnection(e) {
	try {
		if (null !== e.peerConnection) {
			e.peerConnection.close();
			delete e.peerConnection
		}
		var t = null;
		if (coffeeTable.serverParameters.stunServer === undefined
				&& coffeeTable.serverParameters.turnServer === undefined) {
			t = {}
		} else if (undefined !== coffeeTable.serverParameters.stunServer
				&& "" !== coffeeTable.serverParameters.stunServer
				&& coffeeTable.serverParameters.turnServer === undefined) {
			t = {
				iceServers : [ {
					url : coffeeTable.serverParameters.stunServer
				} ]
			}
		} else if (undefined !== coffeeTable.serverParameters.turnServer
				&& "" !== coffeeTable.serverParameters.turnServer
				&& undefined !== coffeeTable.serverParameters.turnUsername
				&& "" !== coffeeTable.serverParameters.turnUsername
				&& undefined !== coffeeTable.serverParameters.turnCredential
				&& "" !== coffeeTable.serverParameters.turnCredential
				&& coffeeTable.serverParameters.stunServer === undefined) {
			t = {
				iceServers : [ {
					url : coffeeTable.serverParameters.turnServer,
					username : coffeeTable.serverParameters.turnUsername,
					credential : coffeeTable.serverParameters.turnCredential
				} ]
			}
		} else {
			t = {
				iceServers : [ {
					url : coffeeTable.serverParameters.stunServer
				}, {
					url : coffeeTable.serverParameters.turnServer,
					username : coffeeTable.serverParameters.turnUsername,
					credential : coffeeTable.serverParameters.turnCredential
				} ]
			}
		}
		e.peerConnection = getNormalizedPeerConnection(t);
		e.peerConnection.onicecandidate = function(t) {
			e.processIceCandidate(t)
		};
		e.peerConnection.onaddstream = function(t) {
			e.processAddStream(t)
		};
		e.peerConnection.addStream(coffeeTable.user.videoStream);
		return true
	} catch (n) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = n;
		errorHandler("createPeerConnection", coffeeTable.error);
		return false
	}
}
function onCreateSessionDescriptionError(e) {
	coffeeTable.error.code = "VC108";
	coffeeTable.error.detailedMessage = e;
	errorHandler("onCreateSessionDescriptionError", coffeeTable.error);
	return false
}
function onSetSessionDescriptionSuccess() {
	return true
}
function onSetSessionDescriptionError(e) {
	coffeeTable.error.code = "VC108";
	coffeeTable.error.detailedMessage = e;
	errorHandler("onSetSessionDescriptionError", coffeeTable.error);
	return false
}
function createNewOffer(e, t) {
	try {
		if (undefined !== t && false === t) {
			t = false
		} else {
			t = true
		}
		if (t) {
			if (!createPeerConnection(e))
				throw "Could not create the peer connection";
			if (!e.peerConnection)
				throw "Peer connection was null."
		}
		e.peerConnection.createOffer(function(t) {
			e.processOffer(t)
		}, onCreateSessionDescriptionError, e.contraints);
		return true
	} catch (n) {
		coffeeTable.error.code = "VC104";
		coffeeTable.error.detailedMessage = n;
		errorHandler("createNewOffer", coffeeTable.error);
		return false
	}
}
function createNewAnswer(e, t) {
	try {
		if (undefined !== t && false === t) {
			t = false
		} else {
			t = true
		}
		if (t) {
			if (!createPeerConnection(e))
				throw "Could not create the peer connection";
			if (!e.peerConnection)
				throw "Peer connection was null."
		}
		e.peerConnection.setRemoteDescription(getRemoteDescription(e.offer),
				onSetSessionDescriptionSuccess, onSetSessionDescriptionError);
		e.isRemoteDescSet = true;
		while (e.iceCandidates.length > 0) {
			onIceCandidate(e.iceCandidates.shift())
		}
		e.peerConnection.createAnswer(function(t) {
			e.processAnswer(t)
		}, onCreateSessionDescriptionError, e.contraints);
		return true
	} catch (n) {
		coffeeTable.error.code = "VC104";
		coffeeTable.error.detailedMessage = n;
		errorHandler("createNewAnswer", coffeeTable.error);
		return false
	}
}
function onRemoteStreamAdded(e, t) {
	try {
		coffeeTable.dialing = false;
		coffeeTable.waitingForParticipants = false;
		showParticipantMessage(e, "Connecting. Please wait.. ");
		if (coffeeTable.meeting.participants[0].isOnline === false
				|| coffeeTable.meeting.participants[0].isOnline === undefined) {
			swapParticipantToMainVideo(e)
		}
		if (window.webkitURL) {
			e.videoSrc.src = window.webkitURL.createObjectURL(t.stream);
			e.videoSrc.muted = false
		} else {
			e.videoSrc.mozSrcObject = t.stream;
			e.videoSrc.muted = false
		}
		checkIceCandidateState(e);
		waitForRemoteStream(e);
		return true
	} catch (n) {
		coffeeTable.error.code = "VC104";
		coffeeTable.error.detailedMessage = n;
		errorHandler("onRemoteStreamAdded", coffeeTable.error);
		return false
	}
}
function waitForRemoteStream(e) {
	try {
		if (!(e.videoSrc.readyState <= HTMLMediaElement.HAVE_CURRENT_DATA
				|| e.videoSrc.paused || e.videoSrc.currentTime <= 0)
				|| e.videoMuted) {
			coffeeTable.meetingStarted = true;
			makeParticipantOnline(e);
			enableAllToggleButtons();
			hideParticipantMessage(e);
			if (true === e.videoMuted) {
				showParticipantName(e);
				if (1 === e.position) {
					showParticipantMessage(e, e.name + " turned off the video")
				} else {
					showParticipantMessage(e, "Video turned off")
				}
			} else {
				hideParticipantName(e);
				showParticipantVideo(e)
			}
			if (true === e.audioMuted) {
				e.videoSrc.muted = true;
				if (1 === e.position) {
					showParticipantMessage(e, e.name + " turned off audio")
				} else {
					showParticipantMessage(e, "Audio muted")
				}
			}
			showParticipantVideoContainer(e);
			if ("Chrome" === coffeeTable.browserName
					&& "low" !== coffeeTable.bandwidth)
				e.trackers.statInterval = setInterval("processStats('"
						+ e.position + "')",
						coffeeTable.serverParameters.statsTimeOut);
			if (coffeeTable.initiator
					&& "connected" === e.peerConnection.iceConnectionState)
				sendCallStarted(e);
			clearTimeout(e.trackers.remoteStreamTimeOut)
		} else {
			e.trackers.remoteStreamTimeOut = setTimeout(function() {
				waitForRemoteStream(e)
			}, 100)
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC104";
		coffeeTable.error.detailedMessage = t;
		errorHandler("waitForRemoteStream", coffeeTable.error);
		return false
	}
}
function getSDP(e) {
	try {
		if (e === undefined || e === null || e === "")
			throw "Session description not defined";
		if (coffeeTable.bandwidth === "low"
				&& null !== coffeeTable.serverParameters.lowAudioBandwidth
				&& null !== coffeeTable.serverParameters.lowVideoBandwidth) {
			e = editSDP(e, coffeeTable.serverParameters.lowAudioBandwidth,
					coffeeTable.serverParameters.lowVideoBandwidth)
		} else if ("1" === coffeeTable.serverParameters.fixedBandwidthFlag
				&& null !== coffeeTable.serverParameters.fixedBandwidthFlag) {
			e = editSDP(e, coffeeTable.serverParameters.defaultAudioBandwidth,
					coffeeTable.serverParameters.defaultVideoBandwidth)
		}
		return e
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		errorHandler("getSDP", coffeeTable.error);
		return false
	}
}
function editSDP(e, t, n) {
	try {
		if (e === undefined || e === null || e === "")
			throw "Session description not defined";
		if (t === undefined || t === null || t === "")
			throw "Audio bandwidth not defined";
		if (n === undefined || n === null || n === "")
			throw "Video bandwidth not defined";
		var r = null;
		var i = e.sdp.split("\r\n");
		for ( var s = 0; s < i.length; s++) {
			if (i[s].search("m=audio") !== -1) {
				r = "b=AS:" + t;
				i.splice(s + 1, 0, r)
			} else if (i[s].search("m=video") !== -1) {
				r = "b=AS:" + n;
				i.splice(s + 1, 0, r)
			}
		}
		e.sdp = i.join("\r\n");
		return e
	} catch (o) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = o;
		errorHandler("editSDP", coffeeTable.error);
		return false
	}
}
function processStats(e) {
	try {
		var t = 0;
		var n = 0;
		var r = coffeeTable.meeting.participants[e - 1];
		var i = getOnlineParticipantCount();
		if (i > 1) {
			clearInterval(r.trackers.statInterval);
			return true
		}
		if (undefined === r || null === r || "" === r)
			return true;
		if (undefined === r.peerConnection || null === r.peerConnection
				|| "" === r.peerConnection)
			return true;
		r.peerConnection
				.getStats(function(e) {
					var t = e.result();
					for ( var n = 0; n < t.length; n++) {
						var r = t[n];
						if ("ssrc" === r.type
								&& r.stat("googFrameHeightReceived")) {
							coffeeTable.stats.bytesReceivedNow = r
									.stat("bytesReceived");
							coffeeTable.stats.bitRate = Math
									.round((coffeeTable.stats.bytesReceivedNow - coffeeTable.stats.bytesReceivedPrevious)
											* 8
											/ coffeeTable.serverParameters.statsTimeOut)
						}
						coffeeTable.stats.bytesReceivedPrevious = coffeeTable.stats.bytesReceivedNow
					}
				});
		if (bitRates.length < coffeeTable.serverParameters.lowThresholdCounter) {
			bitRates.push(coffeeTable.stats.bitRate)
		} else if (bitRates.length === parseInt(coffeeTable.serverParameters.lowThresholdCounter)) {
			for ( var s = 0; s < bitRates.length; s++)
				t = t + bitRates[s];
			n = t / bitRates.length;
			if (n < parseInt(coffeeTable.serverParameters.lowAudioBandwidth)
					+ parseInt(coffeeTable.serverParameters.lowVideoBandwidth)
					&& "low" !== coffeeTable.bandwidth)
				coffeeTable.stats.lowThresholdCounter--;
			else if (n > parseInt(coffeeTable.serverParameters.lowAudioBandwidth)
					+ parseInt(coffeeTable.serverParameters.lowVideoBandwidth)
					&& "low" !== coffeeTable.bandwidth)
				coffeeTable.stats.highThresholdCounter--;
			bitRates.length = 0
		}
		if (0 === coffeeTable.stats.lowThresholdCounter
				&& "low" !== coffeeTable.bandwidth) {
			showParticipantMessage(
					r,
					"Insufficient bandwidth. Try low bandwidth call or turn off video.",
					true);
			coffeeTable.stats.lowThresholdCounter = coffeeTable.serverParameters.lowThresholdCounter
		} else if (0 === coffeeTable.stats.highThresholdCounter
				&& "low" !== coffeeTable.bandwidth) {
			coffeeTable.stats.lowThresholdCounter = coffeeTable.serverParameters.lowThresholdCounter;
			coffeeTable.stats.highThresholdCounter = coffeeTable.serverParameters.highThresholdCounter;
			hideParticipantMessage(r)
		}
		return true
	} catch (o) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = o;
		logError("processStats", coffeeTable.error);
		return false
	}
}
function checkIceCandidateState(e) {
	try {
		if (undefined === e.peerConnection || null === e.peerConnection)
			return true;
		if ("checking" === e.peerConnection.iceConnectionState
				&& null === e.trackers.iceCandidateCheckingStateTimeOut) {
			e.trackers.iceCandidateCheckingStateTimeOut = setTimeout(
					function() {
						checkIceCandidateCheckingState(e)
					}, coffeeTable.serverParameters.timeOut)
		} else if ("failed" === e.peerConnection.iceConnectionState
				|| "disconnected" === e.peerConnection.iceConnectionState
				|| "closed" === e.peerConnection.iceConnectionState) {
			showParticipantMessage(e, "Video connection failed");
			clearTimeout(e.trackers.iceCandidateCheckTimeOut);
			clearTimeout(e.trackers.iceCandidateCheckingStateTimeOut)
		} else if ("connected" === e.peerConnection.iceConnectionState
				|| "completed" === e.peerConnection.iceConnectionState) {
			clearTimeout(e.trackers.iceCandidateCheckTimeOut);
			clearTimeout(e.trackers.iceCandidateCheckingStateTimeOut)
		} else {
			e.trackers.iceCandidateCheckTimeOut = setTimeout(function() {
				checkIceCandidateState(e)
			}, coffeeTable.serverParameters.iceStateTimeOut)
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		logError("checkIceCandidateState", coffeeTable.error);
		return false
	}
}
function checkIceCandidateCheckingState(e) {
	if ("checking" === e.peerConnection.iceConnectionState) {
		showParticipantMessage(e, "Video connection failed");
		clearTimeout(e.trackers.iceCandidateCheckTimeOut);
		clearTimeout(e.trackers.iceCandidateCheckingStateTimeOut)
	}
	return true
}
function toggleMoreChoicesMenu() {
	try {
		if (mrMoreChoicesOptions.is(":visible")) {
			mrMoreChoices.removeClass("more-choice-menu-activated");
			setButtonState(mrMoreChoices, "enabled");
			mrMoreChoicesOptions.hide()
		} else if ("enabled" === getButtonState(mrMoreChoices)) {
			mrMoreChoices.addClass("more-choice-menu-activated");
			setButtonState(mrMoreChoices, "activated");
			mrMoreChoicesOptions.show();
			addParticipant.unbind("click").bind(
					"click",
					function(e) {
						e.preventDefault();
						showAddParticipantsMessageBox(coffeeTableAppName
								+ " Meetings",
								"Enter participant email address.", false)
					});
			startScreenSharing
					.unbind("click")
					.bind(
							"click",
							function(e) {
								e.preventDefault();
								showStartScreenSharingMessageBox(
										coffeeTableAppName + " Meetings",
										"Would you like to share your screen with other participants?")
							})
		}
		$(document).click(function() {
			if (mrMoreChoicesOptions.is(":visible")) {
				mrMoreChoices.removeClass("more-choice-menu-activated");
				setButtonState(mrMoreChoices, "enabled");
				mrMoreChoicesOptions.hide()
			}
		});
		return true
	} catch (e) {
		coffeeTable.error.code = "VC107";
		coffeeTable.error.detailedMessage = e;
		logError("toggleMoreChoicesMenu", coffeeTable.error);
		return false
	}
}
function addParticipantToInstantCall(e) {
	try {
		if (coffeeTable.meeting.participantCount >= MAX_PARTICIPANTS - 1) {
			showUserMessage(
					"Max participant limit reached . You cannot add more participants.",
					true)
		} else if ("" === e) {
			showUserMessage("Please select a valid user.", true)
		} else if (coffeeTable.meeting.participantCount < MAX_PARTICIPANTS
				&& validateEmailId(instantCallAddParticipant, e)) {
			hideMessageBoxInfo();
			disableMessageBoxFormElements();
			hideMessageBox();
			coffeeTable.dialing = true;
			if (!sendAddParticipant(e))
				throw "Could not send add participant command."
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = t;
		errorHandler("addParticipantToInstantCall", coffeeTable.error);
		return false
	}
}
function startInstantVideoCall(e, t, n) {
	try {
		if (coffeeTable.isError) {
			ctMessageBox.show();
			return true
		}
		if (null === e || undefined === e || "" === e)
			throw "Participant Id is not defined.";
		if (null === t || undefined === t || "" === t)
			throw "Participant Name is not defined.";
		if (coffeeTable.isReady && !coffeeTable.onCall) {
			coffeeTable.initiator = true;
			coffeeTable.onCall = true;
			coffeeTable.dialing = true;
			coffeeTable.participants = [ {
				participantId : coffeeTable.user.id,
				participantName : coffeeTable.user.name,
				participantEmailId : coffeeTable.user.email
			}, {
				participantId : e,
				participantName : t,
				participantEmailId : n
			} ];
			attachLocalMedia()
		} else if (coffeeTable.onCall && coffeeTable.initiator) {
			if (coffeeTable.dialing) {
				showUserMessage("Cannot dial to more than more one participants.");
				return true
			} else if (false !== getParticipantIndex(e)) {
				showUserMessage("You are already on call with the user.", true);
				return true
			}
			showMessageBox(coffeeTableAppName + " Meetings",
					"Would like add <b>" + e + "</b> to current session?");
			showMessageBoxButton1("Add");
			ctMessageBoxButton1.unbind("click").bind("click", function(t) {
				t.preventDefault();
				addParticipantToInstantCall(e)
			});
			showMessageBoxButton2("No");
			showMessageBoxCloseButton()
		} else if (coffeeTable.onCall && !coffeeTable.initiator) {
			showUserMessage(
					"You cannot initiate two calls at the same time. Please end this video call, to start another.",
					true)
		} else {
			hideInstantCallMeetingRoom()
		}
		return true
	} catch (r) {
		coffeeTable.isError = true;
		coffeeTable.error.code = "VC101";
		coffeeTable.error.detailedMessage = r;
		errorHandler("startInstantVideoCall", coffeeTable.error);
		return false
	}
}
function makeCall(e) {
	try {
		if (undefined === e)
			displayLocalVideo();
		if (!coffeeTable.meetingStarted) {
			sendInstantCallCreateMeeting();
			startRinging();
			setButtonState(mrCallButton, "disabled", "Call")
		}
		return true
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		errorHandler("makeCall", coffeeTable.error);
		return false
	}
}
function answerCall() {
	try {
		clearTimeout(coffeeTable.trackers.timeout);
		if (!coffeeTable.onCall) {
			releaseLocalMedia();
			return true
		}
		for ( var e = 0; e < coffeeTable.meeting.participants.length; e++)
			showParticipant(coffeeTable.meeting.participants[e]);
		stopRinging();
		displayLocalVideo();
		showInstantCallMeetingRoom();
		bindCoffeeTableButtonEvents();
		setButtonState(mrCallButton, "disabled", "Call");
		hideMessageBox();
		if (!sendParticipantOnline())
			throw "Could not send participant online command.";
		return true
	} catch (t) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = t;
		errorHandler("answerCall", coffeeTable.error);
		return false
	}
}
function startRinging() {
	try {
		ctRingTone[0].play();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = e;
		logError("startRinging", coffeeTable.error)
	}
}
function stopRinging() {
	try {
		ctRingTone[0].pause();
		ctRingTone[0].currentTime = 0;
		return true
	} catch (e) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = e;
		logError("stopRinging", coffeeTable.error);
		return false
	}
}
function playDisconnect() {
	try {
		ctDisconnectTone[0].play();
		return true
	} catch (e) {
		coffeeTable.error.code = "VC108";
		coffeeTable.error.detailedMessage = e;
		logError("playDisconnect", coffeeTable.error);
		return false
	}
}
function getURLParameters() {
	try {
		var e = null;
		var t = window.location.href.slice(
				window.location.href.indexOf("?") + 1).split("&");
		for ( var n = 0; n < t.length; n++) {
			e = t[n].split("=");
			coffeeTable.urlParameters.push(e[0]);
			coffeeTable.urlParameters[e[0]] = decodeURIComponent(e[1])
		}
		return true
	} catch (r) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = r;
		logError("getURLParameters", coffeeTable.error);
		return false
	}
}
function disconnectCoffeeTable() {
	try {
		if (coffeeTable.isReady && coffeeTable.socket.conn !== null) {
			endCoffeeTable();
			"instantCall" === coffeeTable.service ? sendQuit("instantCall")
					: sendParticipantOffline()
		}
		return true
	} catch (e) {
		coffeeTable.error.code = "VC105";
		coffeeTable.error.detailedMessage = e;
		logError("disconnectCoffeeTable", coffeeTable.error);
		return false
	}
}
function initScreenSharing(e) {
	try {
		chrome.runtime.sendMessage("npcneankejhpfibgnpjhacnelblhfglp", {
			getStream : true,
			sources : [ "screen", "window" ]
		}, function(t) {
			onScreenSharingAccessApproved(t.streamId, e)
		});
		return true
	} catch (t) {
		coffeeTable.error.code = "VC109";
		coffeeTable.error.detailedMessage = t;
		logError("initScreenSharing", coffeeTable.error);
		return false
	}
}
function onScreenSharingAccessApproved(e, t) {
	try {
		if (!e || null === e || undefined === e || "" === e) {
			throw "Screen capture access is rejected."
		}
		navigator.webkitGetUserMedia({
			audio : false,
			video : {
				mandatory : {
					chromeMediaSource : "desktop",
					chromeMediaSourceId : e,
					maxWidth : 960,
					maxHeight : 720
				}
			}
		}, function(e) {
			if (!e)
				throw "Unable to capture screen.";
			t.videoSrc.src = window.webkitURL.createObjectURL(e);
			t.video.show();
			showMessageBox(coffeeTableAppName + " Meetings",
					"Screen Sharing Started.")
		}, onScreenSharingUserMediaError);
		return true
	} catch (n) {
		coffeeTable.error.code = "VC109";
		coffeeTable.error.detailedMessage = n;
		logError("onScreenSharingAccessApproved", coffeeTable.error);
		return false
	}
}
function onScreenSharingUserMediaError(e) {
	try {
		throw e
	} catch (e) {
		coffeeTable.error.code = "VC109";
		coffeeTable.error.detailedMessage = e;
		logError("onScreenSharingUserMediaError", coffeeTable.error);
		return false
	}
}
var MAX_PARTICIPANTS = 5;
var coffeeTableAppName = "Coffee Table";
var ctMessageBoxWidowOffsetX = 0, ctMessageBoxWidowOffsetY = -100;
var ctMessageBox, ctMessageBoxTitle, ctMessageBoxClose, ctMessageBoxInfo;
var ctMessageBoxMainTextContainer, ctMessageBoxImageContainer, ctMessageBoxMainText;
var ctMessageBoxSuccessImage, ctMessageBoxLoaderImage, ctMessageBoxUserImage;
var ctMessageBoxDetails, ctMessageBoxDetailsPoints, ctMessageBoxSolutionPoints;
var ctAunthentication, ctAddParticipantsSelectBox, ctTextBox, ctVerificationCode;
var ctAddParticpants;
var ctParticipants = [];
var ctTopic, ctUsername, ctPassword;
var ctMessageBoxCreateMeetingOptions, ctMessageBoxAddMessage, ctMessageBoxMeetingMessage;
var ctMessageBoxButtons, ctMessageBoxButton1, ctMessageBoxButton2;
var coffeeTableErrorBoxClass = "errorBox";
var ctDock, ctDockMaximize, ctDockClose;
var ctRingTone, ctDisconnectTone;
var meeetingRoom, mrNavigationContainer, mrTitleContainer, mrTitle, mrMinimize, mrFullScreen;
var mrMeetingDetailsButton, mrMeetingDetails;
var instantCallWidowOffsetX = 0, instantCallWidowOffsetY = -15;
var participantVideoContainers = [];
var participantRemoveButtonContainers = [];
var participantRemoveButtons = [];
var participantVideos = [];
var participantNames = [];
var participantMessages = [];
var userVideoContainer, userVideo;
var mrAudioMuteButton, mrVideoMuteButton, mrLowBandwidthButton, mrCallButton, mrEndButton;
var mrMoreChoices, mrMoreChoicesOptions, addParticipant, startScreenSharing, stopScreenSharing;
var instantCallAddParticipant;
var ctNotification;
var coffeeTable = new Object;
coffeeTable.error = new Object;
coffeeTable.error.code = null;
coffeeTable.error.message = null;
coffeeTable.error.detailedMessage = null;
coffeeTable.error.solution = null;
coffeeTable.urlParameters = [];
var emailValidationRegEx = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
var bitRates = []