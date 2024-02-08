@extends('layouts.frontend')


@section('styles')
{{-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'> --}}
{{-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'> --}}
<style class="cp-pen-styles">
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap');
  

  .sec-center{
    display:none;
  }
  .content-wrapper{
    margin-top: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200vh;
    height: 95vh;
    background: #27ae60;
    font-family: "Source Sans Pro";
    font-size: 1em;
    letter-spacing: 0.1px;
    color: #32465a;
    text-rendering: optimizeLegibility;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
    -webkit-font-smoothing: antialiased;
    overflow: hidden;
  }
  #frame {
    width: 100%;
    min-width: 360px;
    max-width: 72%;
    height: 92vh;
    min-height: 10px;
    max-height: 720px;
    background: #e6eaea;
    margin-top: 0;
  }
  @media screen and (max-width: 360px) {
    .content-wrapper{
      align-items: unset;
      height: 70vh;
    }

    .iframe{
    width:100%;
    height: 350px;
    margin-left: 12px;
  }
    #frame {
      margin-top: 30px;
      width: 100%;
      height: 65vh;
      font-size: 0.8em;
      border-radius: 10px;
      margin-left: 5px;
      margin-right: 5px;
    }
  }

  .custom-dropdown-btn {
        /* background-color: white; */
        border: 1px solid grey;
    }


    /* ------------------------- */
    #frame #sidepanel {
    float: left;
    max-width: 340px;
    width: 40%;
    height: 100%;
    background: #2c3e50;
    color: #f5f5f5;
    overflow: hidden;
    position: relative;
    z-index: 1;
    transition: width 0.2s ease; /* Add transition for smooth animation */
}

#frame #sidepanel.expanded {
    width: 100%;
}
  @media screen and (max-width: 735px) {
    #frame #sidepanel {
      max-width:100%;
      width: 100%;
      /* min-width: 70px; */
    }
  }
  #frame #sidepanel #profile {
    width: 80%;
    margin: 25px auto;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile {
      width: 100%;
      margin: 0 auto;
      padding: 5px 0 0 0;
      background: #32465a;
    }
  }
  #frame #sidepanel #profile.expanded .wrap {
    height: 210px;
    line-height: initial;
  }
  #frame #sidepanel #profile.expanded .wrap p {
    margin-top: 20px;
  }
  #frame #sidepanel #profile.expanded .wrap i.expand-button {
    -moz-transform: scaleY(-1);
    -o-transform: scaleY(-1);
    -webkit-transform: scaleY(-1);
    transform: scaleY(-1);
    filter: FlipH;
    -ms-filter: "FlipH";
  }
  #frame #sidepanel #profile .wrap {
    height: 60px;
    line-height: 60px;
    overflow: hidden;
    -moz-transition: 0.3s height ease;
    -o-transition: 0.3s height ease;
    -webkit-transition: 0.3s height ease;
    transition: 0.3s height ease;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap {
      height: 55px;
    }
  }
  #frame #sidepanel #profile .wrap img {
    width: 50px;
    border-radius: 50%;
    padding: 3px;
    border: 2px solid #e74c3c;
    height: auto;
    float: left;
    cursor: pointer;
    -moz-transition: 0.3s border ease;
    -o-transition: 0.3s border ease;
    -webkit-transition: 0.3s border ease;
    transition: 0.3s border ease;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap img {
      width: 40px;
      margin-left: 4px;
    }
  }
  #frame #sidepanel #profile .wrap img.online {
    border: 2px solid #2ecc71;
  }
  #frame #sidepanel #profile .wrap img.away {
    border: 2px solid #f1c40f;
  }
  #frame #sidepanel #profile .wrap img.busy {
    border: 2px solid #e74c3c;
  }
  #frame #sidepanel #profile .wrap img.offline {
    border: 2px solid #95a5a6;
  }
  #frame #sidepanel #profile .wrap p {
    float: left;
    margin-left: 15px;
  }

  #frame #sidepanel #profile .wrap i.expand-button {
    float: right;
    margin-top: 23px;
    font-size: 0.8em;
    cursor: pointer;
    color: #435f7a;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap i.expand-button {
      display: none;
    }
  }
  #frame #sidepanel #profile .wrap #status-options {
    position: absolute;
    opacity: 0;
    visibility: hidden;
    width: 150px;
    margin: 70px 0 0 0;
    border-radius: 6px;
    z-index: 99;
    line-height: initial;
    background: #435f7a;
    -moz-transition: 0.3s all ease;
    -o-transition: 0.3s all ease;
    -webkit-transition: 0.3s all ease;
    transition: 0.3s all ease;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap #status-options {
      width: 58px;
      margin-top: 57px;
    }
  }
  #frame #sidepanel #profile .wrap #status-options.active {
    opacity: 1;
    visibility: visible;
    margin: 75px 0 0 0;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap #status-options.active {
      margin-top: 62px;
    }
  }
  #frame #sidepanel #profile .wrap #status-options:before {
    content: '';
    position: absolute;
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 8px solid #435f7a;
    margin: -8px 0 0 24px;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap #status-options:before {
      margin-left: 23px;
    }
  }
  #frame #sidepanel #profile .wrap #status-options ul {
    overflow: hidden;
    border-radius: 6px;
  }
  #frame #sidepanel #profile .wrap #status-options ul li {
    padding: 15px 0 30px 18px;
    display: block;
    cursor: pointer;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap #status-options ul li {
      padding: 15px 0 35px 22px;
    }
  }
  #frame #sidepanel #profile .wrap #status-options ul li:hover {
    background: #496886;
  }
  #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 5px 0 0 0;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
      width: 14px;
      height: 14px;
    }
  }
  #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
    content: '';
    position: absolute;
    width: 14px;
    height: 14px;
    margin: -3px 0 0 -3px;
    background: transparent;
    border-radius: 50%;
    z-index: 0;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
      height: 18px;
      width: 18px;
    }
  }
  #frame #sidepanel #profile .wrap #status-options ul li p {
    padding-left: 12px;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap #status-options ul li p {
      display: none;
    }
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-online span.status-circle {
    background: #2ecc71;
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-online.active span.status-circle:before {
    border: 1px solid #2ecc71;
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-away span.status-circle {
    background: #f1c40f;
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-away.active span.status-circle:before {
    border: 1px solid #f1c40f;
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-busy span.status-circle {
    background: #e74c3c;
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-busy.active span.status-circle:before {
    border: 1px solid #e74c3c;
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-offline span.status-circle {
    background: #95a5a6;
  }
  #frame #sidepanel #profile .wrap #status-options ul li#status-offline.active span.status-circle:before {
    border: 1px solid #95a5a6;
  }
  #frame #sidepanel #profile .wrap #expanded {
    padding: 100px 0 0 0;
    display: block;
    line-height: initial;
  }
  #frame #sidepanel #profile .wrap #expanded label {
    float: left;
    clear: both;
    margin: 0 8px 5px 0;
    padding: 5px 0;
  }
  #frame #sidepanel #profile .wrap #expanded input {
    border: none;
    margin-bottom: 6px;
    background: #32465a;
    border-radius: 3px;
    color: #f5f5f5;
    padding: 7px;
    width: calc(100% - 43px);
  }
  #frame #sidepanel #profile .wrap #expanded input:focus {
    outline: none;
    background: #435f7a;
  }
  #frame #sidepanel #search {
    border-top: 1px solid #32465a;
    border-bottom: 1px solid #32465a;
    font-weight: 300;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #search {
      display: none;
    }
  }
  #frame #sidepanel #search label {
    position: absolute;
    margin: 10px 0 0 20px;
  }
  #frame #sidepanel #search input {
    font-family: "Source Sans Pro";
    padding: 10px 0 10px 46px;
    width: calc(100% - 25px);
    border: none;
    background: #32465a;
    color: #f5f5f5;
  }
  #frame #sidepanel #search input:focus {
    outline: none;
    background: #435f7a;
  }
  #frame #sidepanel #search input::-webkit-input-placeholder {
    color: #f5f5f5;
  }
  #frame #sidepanel #search input::-moz-placeholder {
    color: #f5f5f5;
  }
  #frame #sidepanel #search input:-ms-input-placeholder {
    color: #f5f5f5;
  }
  #frame #sidepanel #search input:-moz-placeholder {
    color: #f5f5f5;
  }
  #frame #sidepanel #contacts {
    height: calc(100% - 177px);
    overflow-y: scroll;
    overflow-x: hidden;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #contacts {
      height: calc(100% - 149px);
      overflow-y: scroll;
      overflow-x: hidden;
    }
    #frame #sidepanel #contacts::-webkit-scrollbar {
      display: none;
    }
  }
  #frame #sidepanel #contacts.expanded {
    height: calc(100% - 334px);
  }
  #frame #sidepanel #contacts::-webkit-scrollbar {
    width: 8px;
    background: #2c3e50;
  }
  #frame #sidepanel #contacts::-webkit-scrollbar-thumb {
    background-color: #243140;
  }
  #frame #sidepanel #contacts ul li.contact {
    position: relative;
    padding: 10px 0 15px 0;
    font-size: 0.9em;
    cursor: pointer;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #contacts ul li.contact {
      padding: 6px 0 46px 8px;
    }
  }
  #frame #sidepanel #contacts ul li.contact:hover {
    background: #32465a;
  }
  #frame #sidepanel #contacts ul li.contact.active {
    background: #32465a;
    border-right: 5px solid #435f7a;
  }
  #frame #sidepanel #contacts ul li.contact.active span.contact-status {
    border: 2px solid #32465a ;
  }
  #frame #sidepanel #contacts ul li.contact .wrap {
    width: 88%;
    margin: 0 auto;
    position: relative;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #contacts ul li.contact .wrap {
      width: 100%;
    }
  }
  #frame #sidepanel #contacts ul li.contact .wrap span {
    position: absolute;
    left: 0;
    margin: -2px 0 0 -2px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #2c3e50;
    background: #95a5a6;
  }
  #frame #sidepanel #contacts ul li.contact .wrap span.online {
    background: #2ecc71;
  }
  #frame #sidepanel #contacts ul li.contact .wrap span.away {
    background: #f1c40f;
  }
  #frame #sidepanel #contacts ul li.contact .wrap span.busy {
    background: #e74c3c;
  }
  #frame #sidepanel #contacts ul li.contact .wrap img {
    width: 40px;
    border-radius: 50%;
    float: left;
    margin-right: 10px;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #contacts ul li.contact .wrap img {
      margin-right: 0px;
    }
  }
  #frame #sidepanel #contacts ul li.contact .wrap .meta {
    padding: 5px 0 0 0;
  }
  @media screen and (max-width: 735px) {
    /* #frame #sidepanel #contacts ul li.contact .wrap .meta {
      display: none;
    } */
  }
  #frame #sidepanel #contacts ul li.contact .wrap .meta .name {
    font-weight: 600;
  }
  #frame #sidepanel #contacts ul li.contact .wrap .meta .preview {
    margin: 5px 0 0 0;
    padding: 0 0 1px;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    -moz-transition: 1s all ease;
    -o-transition: 1s all ease;
    -webkit-transition: 1s all ease;
    transition: 1s all ease;
  }
  #frame #sidepanel #contacts ul li.contact .wrap .meta .preview span {
    position: initial;
    border-radius: initial;
    background: none;
    border: none;
    padding: 0 2px 0 0;
    margin: 0 0 0 1px;
    opacity: .5;
  }
  #frame #sidepanel #bottom-bar {
    position: absolute;
    width: 100%;
    bottom: 0;
  }
  #frame #sidepanel #bottom-bar button {
    float: left;
    border: none;
    width: 50%;
    padding: 10px 0;
    background: #32465a;
    color: #f5f5f5;
    cursor: pointer;
    font-size: 0.85em;
    font-family: "Source Sans Pro";
  }
  @media screen and (max-width: 735px) {

    .hide-btn{
      display: none;
    }
    .sec-center{
      display:block;
    }
    #frame #sidepanel #bottom-bar button {
      float: none;
      width: 100%;
      padding: 15px 0;
    }
  }
  #frame #sidepanel #bottom-bar button:focus {
    outline: none;
  }
  #frame #sidepanel #bottom-bar button:nth-child(1) {
    border-right: 1px solid #2c3e50;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #bottom-bar button:nth-child(1) {
      border-right: none;
      border-bottom: 1px solid #2c3e50;
    }
  }
  #frame #sidepanel #bottom-bar button:hover {
    background: #435f7a;
  }
  #frame #sidepanel #bottom-bar button i {
    margin-right: 3px;
    font-size: 1em;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #bottom-bar button i {
      font-size: 1.3em;
    }
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel #bottom-bar button span {
      display: none;
    }
  }
  #frame .content {
    float: center;
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: relative;
  }
  @media screen and (max-width: 735px) {
    #frame .content {
      width: calc(100% - 10px);
      min-width: 200px ;
    }
  }

  @media screen and (max-width: 735px) {
    #frame .content button{
      width: 66px;
      min-width: 66px;
      font-size: 0.8em;
      padding: 0;
    }
  }
  @media screen and (min-width: 900px) {
    #frame .content {
      width: calc(100% - 362px);
    }
  }
  #frame .content .contact-profile {
    width: 100%;
    height: 60px;
    line-height: 60px;
    background: #f5f5f5;
  }
  #frame .content .contact-profile img {
    width: 40px;
    border-radius: 50%;
    float: left;
    margin: 9px 12px 0 9px;
  }
  #frame .content .contact-profile p {
    float: left;
  }
  #frame .content .contact-profile .social-media {
    float: right;
  }
  #frame .content .contact-profile .social-media i {
    margin-left: 14px;
    cursor: pointer;
  }
  #frame .content .contact-profile .social-media i:nth-last-child(1) {
    margin-right: 20px;
  }
  #frame .content .contact-profile .social-media i:hover {
    color: #435f7a;
  }
  #frame .content .messages {
    height: auto;
    min-height: calc(100% - 93px);
    max-height: calc(100% - 93px);
    overflow-y: scroll;
    overflow-x: hidden;
    width: 100%;
  }
  audio::-webkit-media-controls-panel {
  background-color: #56AEFF;
}
audio::-webkit-media-controls-play-button {
  background-color: #B1D4E0;
  border-radius: 50%;
}

audio::-webkit-media-controls-play-button:hover {
  background-color: rgba(177,212,224, .7);
}

  @media screen and (max-width: 735px) {
    #frame .content .messages {
      max-height: calc(100% - 105px);
    }
  }
  #frame .content .messages::-webkit-scrollbar {
    width: 8px;
    background: transparent;
  }
  #frame .content .messages::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.3);
  }
  #frame .content .messages ul li {
    display: inline-block;
    clear: both;
    float: left;
    margin: 15px 15px 5px 15px;
    width: calc(100% - 25px);
    font-size: 0.9em;
  }
  #frame .content .messages ul li:nth-last-child(1) {
    margin-bottom: 20px;
  }
  /* #frame .content .messages ul li.sent img {
    margin: 2px 2px 0 0;
  } */
  #frame .content .messages ul li.sent p {
    background: #435f7a;
    color: #f5f5f5;
  }
  #frame .content .messages ul li.replies img {
    float: right;
    margin: 6px 0 0 8px;
  }
  #frame .content .messages ul li.replies p {
    background: #f5f5f5;
    float: right;
  }
  #frame .content .messages ul li img {
    width: 22px;
    border-radius: 50%;
    float: left;
  }
  #frame .content .messages ul li p {
    display: inline-block;
    padding: 10px 15px;
    border-radius: 20px;
    max-width: 205px;
    line-height: 130%;
  }
  @media screen and (min-width: 735px) {
    #frame .content .messages ul li p {
      max-width: 300px;
    }
  }
  #frame .content .message-input {
    position: absolute;
    bottom: 0;
    width: 100%;
    z-index: 99;
  }
  #frame .content .message-input .wrap {
    position: relative;
  }
  #frame .content .message-input .wrap input {
    font-family: "Source Sans Pro";
    float: left;
    border: none;
    width: calc(100% - 90px);
    padding: 11px 32px 10px 8px;
    font-size: 0.8em;
    color: #32465a;
  }
  @media screen and (max-width: 735px) {
    #frame .content .message-input .wrap input {
      padding: 15px 32px 16px 8px;
    }
  }
  #frame .content .message-input .wrap input:focus {
    outline: none;
  }
  #frame .content .message-input .wrap .attachment {
    position: absolute;
    right: 60px;
    z-index: 4;
    margin-top: 10px;
    font-size: 1.1em;
    color: #435f7a;
    opacity: .5;
    cursor: pointer;
  }
  @media screen and (max-width: 735px) {
    #frame .content .message-input .wrap .attachment {
      margin-top: 17px;
      right: 65px;
    }
  }
  #frame .content .message-input .wrap .attachment:hover {
    opacity: 1;
  }
  #frame .content .message-input .wrap button {
    float: right;
    border: none;
    width: 50px;
    padding: 12px 0;
    cursor: pointer;
    background: #32465a;
    color: #f5f5f5;
  }
  @media screen and (max-width: 735px) {
    #frame .content .message-input .wrap button {
      padding: 16px 0;
    }
  }
  #frame .content .message-input .wrap button:hover {
    background: #435f7a;
  }
  #frame .content .message-input .wrap button:focus {
    outline: none;
  }



  .button-29 {
  align-items: center;
  appearance: none;
  background-image: radial-gradient(100% 100% at 100% 0, #5adaff 0, #5468ff 100%);
  border: 0;
  border-radius: 6px;
  box-shadow: rgba(45, 35, 66, .4) 0 2px 4px,rgba(45, 35, 66, .3) 0 7px 13px -3px,rgba(58, 65, 111, .5) 0 -3px 0 inset;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-flex;
  font-family: "JetBrains Mono",monospace;
  height: 48px;
  justify-content: center;
  line-height: 1;
  list-style: none;
  overflow: hidden;
  padding-left: 16px;
  padding-right: 16px;
  position: relative;
  text-align: left;
  text-decoration: none;
  transition: box-shadow .15s,transform .15s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
  will-change: box-shadow,transform;
  font-size: 18px;
}

.button-29:focus {
  box-shadow: #3c4fe0 0 0 0 1.5px inset, rgba(45, 35, 66, .4) 0 2px 4px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
}

.button-29:hover {
  box-shadow: rgba(45, 35, 66, .4) 0 4px 8px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
  transform: translateY(-2px);
}

.button-29:active {
  box-shadow: #3c4fe0 0 3px 7px inset;
  transform: translateY(2px);
}




.button-30 {
  align-items: center;
  appearance: none;
  background-image: radial-gradient(100% 100% at 100% 0, #f4ea2f 0, #ef2d2a 100%);
  border: 0;
  border-radius: 6px;
  box-shadow: rgba(45, 35, 66, .4) 0 2px 4px,rgba(45, 35, 66, .3) 0 7px 13px -3px,rgba(58, 65, 111, .5) 0 -3px 0 inset;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-flex;
  font-family: "JetBrains Mono",monospace;
  height: 48px;
  justify-content: center;
  line-height: 1;
  list-style: none;
  overflow: hidden;
  padding-left: 16px;
  padding-right: 16px;
  position: relative;
  text-align: left;
  text-decoration: none;
  transition: box-shadow .15s,transform .15s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
  will-change: box-shadow,transform;
  font-size: 18px;
}

.button-30:focus {
  box-shadow: #eb6a56 0 0 0 1.5px inset, rgba(45, 35, 66, .4) 0 2px 4px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
}

.button-30:hover {
  box-shadow: rgba(45, 35, 66, .4) 0 4px 8px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
  transform: translateY(-2px);
}

.button-30:active {
  box-shadow: #e5b5a2 0 3px 7px inset;
  transform: translateY(2px);
}




/* Please ❤ this if you like it! */



*,
*::before,
*::after {
  box-sizing: border-box;
}

.sec-center {
  position: relative;
  max-width: 100%;
  text-align: center;
  font-size: 1em;
  z-index: 200;
}
[type="checkbox"]:checked,
[type="checkbox"]:not(:checked){
  position: absolute;
  left: -9999px;
  opacity: 0;
  pointer-events: none;
}
.dark-light:checked + label,
.dark-light:not(:checked) + label{
  position: fixed;
  top: 40px;
  right: 40px;
  z-index: 20000;
  display: block;
  border-radius: 50%;
  width: 46px;
  height: 46px;
  cursor: pointer;
  transition: all 200ms linear;
  box-shadow: 0 0 25px rgba(255,235,167,.45);
}
.dark-light:checked + label{
  transform: rotate(360deg);
}
.dark-light:checked + label:after,
.dark-light:not(:checked) + label:after{
  position: absolute;
  content: '';
  top: 1px;
  left: 1px;
  overflow: hidden;
  z-index: 2;
  display: block;
  border-radius: 50%;
  width: 44px;
  height: 44px;
  background-color: #102770;
  background-image: url('https://assets.codepen.io/1462889/moon.svg');
  background-size: 20px 20px;
  background-repeat: no-repeat;
  background-position: center;
  transition: all 200ms linear;
  opacity: 0;
}
.dark-light:checked + label:after {
  opacity: 1;
}
.dark-light:checked + label:before,
.dark-light:not(:checked) + label:before{
  position: absolute;
  content: '';
  top: 0;
  left: 0;
  overflow: hidden;
  z-index: 1;
  display: block;
  border-radius: 50%;
  width: 46px;
  height: 46px;
  background-color: #48dbfb;
  background-image: url('https://assets.codepen.io/1462889/sun.svg');
  background-size: 25px 25px;
  background-repeat: no-repeat;
  background-position: center;
  transition: all 200ms linear;
}
.dark-light:checked + label:before{
  background-color: #000;
}
.light-back{
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
  background-color: #fff;
  overflow: hidden;
  background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/pat-back.svg');
  background-position: center;
  background-repeat: repeat;
  background-size: 4%;
  height: 100%;
  width: 100%;
  transition: all 200ms linear;
  opacity: 0;
}
.dark-light:checked ~ .light-back{
  opacity: 1;
}
.dropdown:checked + label,
.dropdown:not(:checked) + label{
  position: relative;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  font-size: 15px;
  line-height: 2;
  height: 40px;
  transition: all 200ms linear;
  border-radius: 4px;
  width: 110px;
  margin-left: 6rem;
  margin-right: 1px;
  letter-spacing: 1px;
  display: -webkit-inline-flex;
  display: -ms-inline-flexbox;
  display: inline-flex;
  -webkit-align-items: center;
  -moz-align-items: center;
  -ms-align-items: center;
  align-items: center;
  -webkit-justify-content: center;
  -moz-justify-content: center;
  -ms-justify-content: center;
  justify-content: center;
  -ms-flex-pack: center;
  text-align: center;
  border: none;
  background-color: #ffeba7;
  cursor: pointer;
  color: #102770;
  box-shadow: 0 12px 35px 0 rgba(255,235,167,.15);
}
.dark-light:checked ~ .sec-center .for-dropdown{
  background-color: #102770;
  color: #ffeba7;
  box-shadow: 0 12px 35px 0 rgba(16,39,112,.25);
}
.dropdown:checked + label:before,
.dropdown:not(:checked) + label:before{
  position: fixed;
  top: 0;
  left: 0;
  content: '';
  width: 100%;
  height: 100%;
  z-index: -1;
  cursor: auto;
  pointer-events: none;
}
.dropdown:checked + label:before{
  pointer-events: auto;
}
.dropdown:not(:checked) + label .uil {
  font-size: 24px;
  margin-left: 10px;
  transition: transform 200ms linear;
}
.dropdown:checked + label .uil {
  transform: rotate(180deg);
  font-size: 24px;
  margin-left: 10px;
  transition: transform 200ms linear;
}
.section-dropdown {
  position: absolute;
  padding: 5px;
  background-color: #111;
  top: 70px;
  left: 0;
  width: 100%;
  border-radius: 4px;
  display: block;
  box-shadow: 0 14px 35px 0 rgba(9,9,12,0.4);
  z-index: 2;
  opacity: 0;
  pointer-events: none;
  transform: translateY(20px);
  transition: all 200ms linear;
}
.dark-light:checked ~ .sec-center .section-dropdown {
  background-color: #fff;
  box-shadow: 0 14px 35px 0 rgba(9,9,12,0.15);
}
.dropdown:checked ~ .section-dropdown{
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}
.section-dropdown:before {
  position: absolute;
  top: -20px;
  left: 0;
  width: 100%;
  height: 20px;
  content: '';
  display: block;
  z-index: 1;
}
.section-dropdown:after {
  position: absolute;
  top: -7px;
  left: 30px;
  width: 0; 
  height: 0; 
  border-left: 8px solid transparent;
  border-right: 8px solid transparent; 
  border-bottom: 8px solid #111;
  content: '';
  display: block;
  z-index: 2;
  transition: all 200ms linear;
}
.dark-light:checked ~ .sec-center .section-dropdown:after {
  border-bottom: 8px solid #fff;
}

.a {
  position: relative;
  color: #fff;
  transition: all 200ms linear;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  font-size: 15px;
  border-radius: 2px;
  padding: 5px 0;
  padding-left: 20px;
  padding-right: 15px;
  margin: 2px 0;
  text-align: left;
  text-decoration: none;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-items: center;
  -moz-align-items: center;
  -ms-align-items: center;
  align-items: center;
  justify-content: space-between;
    -ms-flex-pack: distribute;
}
.dark-light:checked ~ .sec-center .section-dropdown a {
  color: #102770;
}
.a:hover {
  color: #102770;
  background-color: #ffeba7;
}
.dark-light:checked ~ .sec-center .section-dropdown a:hover {
  color: #ffeba7;
  background-color: #102770;
}
.a .uil {
  font-size: 22px;
}
.dropdown-sub:checked + label,
.dropdown-sub:not(:checked) + label{
  position: relative;
  color: #fff;
  transition: all 200ms linear;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  font-size: 15px;
  border-radius: 2px;
  padding: 5px 0;
  padding-left: 20px;
  padding-right: 15px;
  text-align: left;
  text-decoration: none;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-items: center;
  -moz-align-items: center;
  -ms-align-items: center;
  align-items: center;
  justify-content: space-between;
    -ms-flex-pack: distribute;
    cursor: pointer;
}
.dropdown-sub:checked + label .uil,
.dropdown-sub:not(:checked) + label .uil{
  font-size: 22px;
}
.dropdown-sub:not(:checked) + label .uil {
  transition: transform 200ms linear;
}
.dropdown-sub:checked + label .uil {
  transform: rotate(135deg);
  transition: transform 200ms linear;
}
.dropdown-sub:checked + label:hover,
.dropdown-sub:not(:checked) + label:hover{
  color: #102770;
  background-color: #ffeba7;
}
.dark-light:checked ~ .sec-center .section-dropdown .for-dropdown-sub{
  color: #102770;
}
.dark-light:checked ~ .sec-center .section-dropdown .for-dropdown-sub:hover{
  color: #ffeba7;
  background-color: #102770;
}

.section-dropdown-sub {
  position: relative;
  display: block;
  width: 100%;
  pointer-events: none;
  opacity: 0;
  max-height: 0;
  padding-left: 10px;
  padding-right: 3px;
  overflow: hidden;
  transition: all 200ms linear;
}
.dropdown-sub:checked ~ .section-dropdown-sub{
  pointer-events: auto;
  opacity: 1;
  max-height: 999px;
}
.section-dropdown-sub a {
  font-size: 14px;
}
.section-dropdown-sub a .uil {
  font-size: 20px;
}
.logo {
	position: fixed;
	top: 50px;
	left: 40px;
	display: block;
	z-index: 11000000;
  background-color: transparent;
  border-radius: 0;
  padding: 0;
	transition: all 250ms linear;
}
.logo:hover {
  background-color: transparent;
}
.logo img {
	height: 26px;
	width: auto;
	display: block;
  transition: all 200ms linear;
}
.dark-light:checked ~ .logo img{
  filter: brightness(10%);
}

@media screen and (max-width: 991px) {
.logo {
	top: 30px;
	left: 20px;
}
.dark-light:checked + label,
.dark-light:not(:checked) + label{
  top: 20px;
  right: 20px;
}
}

#backButton{
  display: none;
}



.sec-center{
  display:none;
}

.bread{
    display: flex;
  }
  .bread div{
    margin-left:15%;
    width: 10%;
  }
  #bt{
    margin-left: 30rem;
  }

@media screen and (max-width: 760px) and (min-width: 320px){

  #sidepanel{
    width: 100%;
  }
  .bread{
    display: flex
  }
  .bread div{
    margin-left:1rem;
  }
  #bt{
    margin-left: 7rem;
  }
  .contact-profile{
    width: 98%;
    display:flex;
  }

  .sec-center{
    display: flex;
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
    width: auto;
}
  #backButton {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 2rem;
    width: 3rem;
    background-color: none;
    border: none; 
    outline: none; 
    cursor: pointer;
    margin-top: 0px;
}

.bttns{
  margin: auto;
  display: flex
}

#backButton svg {
    width: 20px; 
    height: 20px; 
    fill: currentColor; 
}
  #frame{
    height: 80vh;
    font-size: 16px;
    border-radius: 2px;
    overflow: hidden;
  }
  .content{
    display:none;
  }
  #content{
    display: block;
    margin: auto;
    float: center;
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: relative;
    z-index: 2;
  }
  
  .to{
    width: auto;
    height: 2rem;
    display: flex;
    align-items: center;
    margin-top: 9px;
  }
  .to p{
    margin-left: auto;
  }
  .to p p{
    margin-right: auto;
  }
}

@media screen and (max-width: 1080px) and (min-width: 768px){
  #frame .content {
    width: calc(100% - 358px);
}
  .bttns{
    width: 100%;
  }
  .butts{
    
  }
}




/* camera */
.image-container {
    max-height: 90%;
    overflow-y: auto;
    margin-left:10px;
    margin-top: 10px;
}

.image-container img{
    width: 160px;
    height: 160px;
    object-fit: cover;
    margin-bottom: 10px;
    border-radius: 6px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 

}

/* call logs */
.scrollable-content_call_log {
    max-height: 80%; /* Adjust the max height as needed */
    overflow-y: auto;
    margin-top: 20px;
    margin-left: 10px;
}


.message-text {
    display: block;
    padding: 10px;
    background-color: #f8d7da; /* Light red background */
    color: #721c24; /* Dark red text color */
    border: 1px solid #f5c6cb; /* Border color */
    border-radius: 4px; /* Rounded corners */
    text-align: center; /* Center text */
    font-weight: bold; /* Bold text */
}
  </style>
  
  @livewireStyles
@endsection
@section('main-container')
@livewireScripts
{{ $slot }}
@endsection