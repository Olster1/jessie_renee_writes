<?php
  $db_file = fopen("posts.txt", "r") or die("unable to open file");

  $posts = "[";
  $currentString = "";
  $lineNum = 0;
  while(!feof($db_file)) {
    $line = fgets($db_file);
    if(strlen($line) >= 2 && $line[0] == '/' && $line[1] == '/') {
      if(strlen($currentString) > 0) {
        $posts .= $currentString . "\"}, ";  
        $lineNum = 0;
        $currentString = "";
      }
    } else {
      $toAdd = substr($line, 0, (strlen($line) - 2));
      if($lineNum == 0) {
          $currentString .= "{date: \"" . $toAdd . "<br>\", ";
        } else if($lineNum == 1) {
          $currentString .= "title: \"" . $toAdd . "<br>\", ";
        } else if ($lineNum == 2){
          $currentString .= "text: \"" . $toAdd;  
        } else {
          $currentString .= $toAdd;  
        }

      $lineNum++;
      
    }
  }
  
  $posts .= "]";
  fclose($db_file);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Jessie Renee Writes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Homemade+Apple|Marck+Script|Montserrat|Poppins:400|Raleway|Reenie+Beanie" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
  
  <div style="width: 100%; max-width: 100%; overflow: hidden;">
    <img id="background-image" src="jessie-renee-website-background.jpg" />
      <div id="nav-bar"></div>
      <div id="book-carousel">
        <div style="position: absolute; bottom: 5%; left: 80%; z-index: 1"><button id="left-scroll-btn"><span><</span></button><button id="right-scroll-btn"><span>></span></button></div>
      </div>
      <div id="signup-form" style="position: fixed; width: 30em; bottom: -100em;">
        <img src="Pop up.png" style="position: absolute; width: 100%; z-index: 0;"/>
        <div style="text-align: left; display: inline-block; position: relative; top: 3em; left: 14em; width: 50%; font-family: 'Raleway', sans-serif; color: white;">
        <button id="signup-form-exit-btn" style="position: absolute; border-radius: 1em; padding-left: 0.2em; padding-right: 0.2em; font-size: 14pt; background-color: gray; border: none; top: -0.8em; color: black; right: -0.8em;">X</button>
        <form action="http://www.sendy.edgeeffectmedia.com/subscribe" method="POST" accept-charset="utf-8">
          <p style="line-height: 130%;">Signup to get exclusive updates & read Ghost Storm for FREE</p>
          <span style="line-height: 300%">
          <label for="name"><b>Name</b></label>
          <input style="position: relative; background-color: gray; color: white; border: none; padding-left: 0.5em; padding-right: 0.5em; right: 0;" type="text" name="name" id="name"/>
          <br/>
          <label for="email"><b>Email</b></label>
          <input style="position: relative; background-color: gray; color: white; border: none; padding-left: 0.5em; padding-right: 0.5em; left: 0.3em;" type="email" name="email" id="email"/>
          <br/>
          <input type="hidden" name="list" value="PsWbB1YsrVSedE6TE9jD8w"/>
          <div style="text-align: center"><input style="border: none; background-color: white; padding-left: 0.5em; padding-right: 0.5em; font-weight: bold;" type="submit" name="submit" value="Get my Free Book" id="submit"/></div>
          
          </span>
        </form>
        
        </div>
      </div>
      <div id="social-media" style="text-align: center;"></div>
      <div id="blog-posts" style="display: inline-block; width: 45%; vertical-align: top"></div><!-- LightWidget WIDGET --><script src="//lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/c0b9af16f9a35017819997a7a7cee54c.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden; width: 45%;"></iframe>
      <div id="home-section"></div>

  </div>
<script>

function clamp(min, value, max) {
  if(value < min) {
    value = min;
  }
  if(value > max) {
    value = max;
  }
  return value;
}

function tLinear_to_tSineous(t) {
    var result = 0.5*Math.cos(t*Math.PI - Math.PI) + 0.5;

    return result;
  }

function lerp(A, t, B) {
  return (B - A)*t + A;
}

window.onload = function() {

  function createNavLinkString(name, extraClassName, isInline) {
    var inlineValue = (isInline) ? "inline" : "block";
    return "<a class='nav-link " + extraClassName + "' id='nav-item-" + name + "' href='./#" + name + "'><div style='display:" + inlineValue +"; position: relative;'>" + name + "</div></a>";
  }
  var navLinks = ["Home", "Books", "About", "Contact", "Blog"];
  var books = ["Hidden Bay", "White City"];

  var navBar = document.getElementById("nav-bar");
  var navLinkString = "";
  for(var i = 0; i < navLinks.length; i++) {
    navLinkString += createNavLinkString(navLinks[i], "", true); 
    if(navLinks[i] === "Books") {
      navLinkString += "<div class='drop-down-menu' id='drop-down-menu-" + navLinks[i] + "'>";
      for(var booksIndex = 0; booksIndex < books.length; booksIndex++) {
        navLinkString += createNavLinkString(books[booksIndex], "nav-link-drop-down", false);
      }
      navLinkString += "</div>";
    } 
  }
  navBar.innerHTML = navLinkString;

  var socialMedia = [
  {imageUrl: "facebook_logo.png", webUrl: "http://www.facebook.com/jessiereneewrites"},
  {imageUrl: "instagram_logo.png", webUrl: "http://www.instagram.com/jessiereneewrites"},
  {imageUrl: "youtube_logo.png", webUrl: "https://www.youtube.com/channel/UCqnBnPEtOjDtOBb_fxrmi4w"},
  {imageUrl: "pinterest_logo.png", webUrl: "http://www.pinterest.com/jessieandco"}
  ];

  var socialElm = document.getElementById("social-media");
  for(var i = 0; i < socialMedia.length; ++i) {
    socialElm.innerHTML += "<a href='" + socialMedia[i].webUrl + "'><img style='width: 5%; padding: 5%;' src='" + socialMedia[i].imageUrl + "'/></a>";
  }

  var blogPosts = <?php echo $posts; ?>;

  var blogElm = document.getElementById("blog-posts");
  for(var i = 0; i < blogPosts.length; ++i) {
    blogElm.innerHTML += "<div style='padding: 2%;'>" + blogPosts[i].date + "<a href='./blog/" + blogPosts[i].title + "'>" + blogPosts[i].title + "</a>" + blogPosts[i].text + "</div>";
  }  

  var MOVE_LEFT  = 1; 
  var MOVE_RIGHT = 2; 
  var MOVE_UP  = 3; 
  var MOVE_DOWN = 4; 

  var SHOW = 0;
  var HIDE = 1;

  var FORM_BOX_INVISIBLE = -0.3;
  var FORM_BOX_VISIBLE = 0.16;
  
  var LEFT_PERCENT = -1;
  var MIDDLE_PERCENT = 0;
  var RIGHT_PERCENT = 1.2;

  var animations = [];

  var carouselContent = [
  {text: "The confines of their camp are all they’ve ever known. But a girl they call Mouse believes the rumours are true — liberation is coming.<br>Friends betray her, enemies become allies. And the refuge she seeks in White City might just be the most dangerous thing of all.<br><a href='./white_city'>Read More</a>", imageUrl: "white_city.png"},
  {text: "Melodie receives an inheritance she never expected -- not just a haunted house, but a whole haunted town. Plus growing psychic abilities that tell her danger is coming. But what's the point of seeing the future, if you can't even protect the people you care about most?<br><a href='./hidden_bay'>Read More</a>", imageUrl: "HB_book_tablet.png"},
  {text: "It was foolish. Taking off her engagement ring for just one night. It wasn’t meant to become anything…</p><p>But now fate won’t let Ashley forget Ethan, even if she wanted to.</p><a href='./crossing_paths'>Read More</a>", imageUrl: "crossing_paths.png"}];


  function addAnimation(tPeriod, objectToModify, variableName, type, domObject) {
  	var object = {tAt: 0, period: tPeriod, minValue: 0, maxValue: 0, object: objectToModify, variableName: variableName, callBack: null, type: type, domObject: domObject, updating: false};
  	var lengthOfArray = animations.push(object);
  	return (lengthOfArray - 1);
  }

  function createCarouselItem(index, xPercent) {
    var carElm = carouselContent[index];
    var startX = (xPercent*100) + "%";
    var styleString = "position: relative; padding-right: 2%; padding-left: 2%; display: inline-block; width: 40%; vertical-align: top; top: 5vw; text-align: left; font-size: 1.8vw; line-height: 100%;";

    return "<span id='carousel" + index + "' style='text-align: center; position: absolute;display: inline-block; width: 100%; left: " + startX + "'><div style='" + styleString + "'>" + carElm.text + "</div>" + "<img style='height: 30vw; ' src='" + carElm.imageUrl + "'></span>";
  }

  var GlobalCarouselIndex = 0;
  var carousel = document.getElementById("book-carousel");

  var Positions = [MIDDLE_PERCENT, LEFT_PERCENT, RIGHT_PERCENT];
  var carouselHtmlString = "";  
  for(var i = 0; i < carouselContent.length; ++i) {
    carouselHtmlString += createCarouselItem(i, Positions[i]);
  }
  carousel.innerHTML += carouselHtmlString;

  for(var i = 0; i < carouselContent.length; ++i) {
  	var thisCarousel = document.getElementById("carousel" + i)
  	var tPeriod = 3.0;
	  addAnimation(tPeriod, thisCarousel.style, "left", "carousel", null, null);
  }

//TODO: make a spot to put second parameter in addAnimation()
  var FormIndex = addAnimation(0.4, document.getElementById("signup-form").style, "bottom", "", null);

  var BookDropDownIndex = addAnimation(3.0, document.getElementById("drop-down-menu-Books").style, "height", "", document.getElementById("drop-down-menu-Books"));

  function moveItemOn(moveDirection) {
    autoChangeTimer = 0;

    switch(moveDirection) {
      case MOVE_LEFT: {
        var car1 = animations[GlobalCarouselIndex]; //make this into an index array
        var index1 = ((GlobalCarouselIndex - 1) >= 0) ? GlobalCarouselIndex - 1: carouselContent.length -1;
        var car2 = animations[index1];
          
        if(!car1.updating && !car2.updating) {
          car1.minValue = MIDDLE_PERCENT;
          car1.maxValue = LEFT_PERCENT;
          car1.updating = true;
          
          car2.minValue = RIGHT_PERCENT;
          car2.maxValue = MIDDLE_PERCENT;
          car2.updating = true;

          GlobalCarouselIndex = index1;
        }

        break;
      }
      case MOVE_RIGHT: {
        var car1 = animations[GlobalCarouselIndex];
        var index1 = ((GlobalCarouselIndex + 1) < carouselContent.length) ? GlobalCarouselIndex + 1: 0;
        var car2 = animations[index1];
        
        if(!car1.updating && !car2.updating) {
          car1.minValue = MIDDLE_PERCENT;
          car1.maxValue = RIGHT_PERCENT;
          car1.updating = true;
          
          car2.minValue = LEFT_PERCENT;
          car2.maxValue = MIDDLE_PERCENT;
          car2.updating = true;

          GlobalCarouselIndex = index1;
        }
        break;
      }
    }
  }

  //////////////////////

  var signupExit = document.getElementById("signup-form-exit-btn");
  signupExit.addEventListener("click", function(e) {
    beginFormMove(MOVE_DOWN);
  });

  var leftBtn = document.getElementById("left-scroll-btn");
  leftBtn.addEventListener("click", function(e) {
    moveItemOn(MOVE_LEFT);
  });

  var rightBtn = document.getElementById("right-scroll-btn");
  rightBtn.addEventListener("click", function(e) {
    moveItemOn(MOVE_RIGHT);
  });

  var isHovering0 = false;
  var isHovering1 = false;


  var booksNavItem = document.getElementById("nav-item-Books");
  booksNavItem.addEventListener("mouseover", function(e) {
    toggleDropDownMenu(SHOW);
    isHovering0 = true;
  });
  booksNavItem.addEventListener("mouseout", function(e) {
    isHovering0 = false;
    if(!isHovering0 && !isHovering1) toggleDropDownMenu(HIDE);
  });

  var menuItem = document.getElementById("drop-down-menu-Books");
  menuItem.addEventListener("mouseover", function(e) {
    isHovering1 = true;
    toggleDropDownMenu(SHOW);
  });
  menuItem.addEventListener("mouseout", function(e) {
    isHovering1 = false;
    if(!isHovering0 && !isHovering1) toggleDropDownMenu(HIDE);
  });


  function getOppositeState(state) {
    var res = MOVE_NULL;
    if(state === SHOW) {
      res = MOVE_DOWN;
    } else if(state === HIDE) {
      res = MOVE_UP;
    }
    return res;
  }

  function toggleDropDownMenu(state) {
      // if(currentDropDownState !== MOVE_NULL && currentDropDownState !== getOppositeState(state)) {
      //   dropDownMenu_t = 1.0 - dropDownMenu_t;
      // }
      var DropDownAnim = animations[BookDropDownIndex];
      console.log(DropDownAnim);
      DropDownAnim.domObject.style.display = "inline";
      DropDownAnim.tAt = 0.0;
      console.log(state);
      if(state === SHOW) {
        DropDownAnim.minValue = 0;
        DropDownAnim.maxValue = 1;
      } else if(state === HIDE) {
        DropDownAnim.minValue = 1;
        DropDownAnim.maxValue = 0;
      }

      DropDownAnim.updating = true;
      DropDownAnim.callBack = function() {
        if(DropDownAnim.maxValue === 0) {
            DropDownAnim.domObject.style.display = "none";
          } 
      };
  }

  var animationTime = 1.0/30.0;

  window.setTimeout(function(){ 
    beginFormMove(MOVE_UP);
  }, 2000);

  function beginFormMove(move) {
    var FormAnimation = animations[FormIndex];
    FormAnimation.tAt = 0.0;
    if(move === MOVE_DOWN) { 
      FormAnimation.minValue = FORM_BOX_VISIBLE;
      FormAnimation.maxValue = FORM_BOX_INVISIBLE;
    } else if(move === MOVE_UP) {
      FormAnimation.minValue = FORM_BOX_INVISIBLE;
      FormAnimation.maxValue = FORM_BOX_VISIBLE;
    }
    FormAnimation.updating = true;
  }

  function getPercentValueAt(minValue, t, maxValue, period) {
    return (100*lerp(minValue, tLinear_to_tSineous(t / period), maxValue)) + "%";
  }

  var autoChangeTimer = 0;
  window.setInterval(function(){
    var updateCarousel = true;
  	for(var i = 0; i < animations.length; ++i) {

  		var anim = animations[i];
  		if(anim.updating) {
  			anim.tAt += animationTime;
	  		anim.object[anim.variableName] = getPercentValueAt(anim.minValue, anim.tAt, anim.maxValue, anim.period);
	  		if((anim.tAt / anim.period) > 1) {
	  		    anim.tAt = 0;
	  		    anim.updating = false;
	  		    if(anim.callback) {
	  		    	anim.callback();
	  		    }
	  		}
	  	}
	  	if(anim.type === "carousel") {
	  		updateCarousel &= (!anim.updating);
	  	}
  	}

  	if(updateCarousel) {
      autoChangeTimer += animationTime;  
      if(autoChangeTimer > 2) {
        moveItemOn(MOVE_RIGHT);
      }
    }
  }, animationTime*1000); 

  //Router
  function handleNewHash() {
    var location = window.location.hash.replace(/^#\/?|\/$/g, '').split('/');
    switch (location[0])  {
    case '':

    	break;
    case 'About':
      break;
    default:
      
      break;
    }
  }

  handleNewHash();
  window.addEventListener('hashchange', handleNewHash, false);

  function setDropDownMenuItemsPosition(newPosType) {
    var elements = document.getElementsByClassName("drop-down-menu");
    for(var i = 0; i < elements.length; ++i) {
      var elm = elements[i];
      elm.style.position = newPosType;
    }
  }

  function mediaQueryResponse (mq) {
    if (mq.matches) {
      setDropDownMenuItemsPosition("static");
    } else {
      setDropDownMenuItemsPosition("absolute");
    }  
  }

  var mq = window.matchMedia('screen and (max-width: 820px)');
  mediaQueryResponse(mq);
  mq.addListener(mediaQueryResponse);
}
</script>

</body>
</html>
