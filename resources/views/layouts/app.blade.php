@extends('layouts.frontend')


@section('styles')
{{-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'> --}}
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
<style class="cp-pen-styles">
  .sec-center{
    display:none;
  }
  .content-wrapper{
    margin-top: 0rem;
    display: flex;
    align-items: center;
    justify-content: center;
    /* min-height: 200vh; */
    height: 100vh;
    background: #27ae60;
    font-family: "Source Sans Pro";
    font-size: 1em;
    letter-spacing: 0.1px;
    color: #32465a;
    text-rendering: optimizeLegibility;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
    -webkit-font-smoothing: antialiased;
  }
  #frame {
    width: 100%;
    min-width: 360px;
    max-width: 72%;
    height: 92vh;
    min-height: 300px;
    max-height: 720px;
    background: #e6eaea;
  }
  @media screen and (max-width: 360px) {
    .content-wrapper{
      align-items: unset;
      height: 70vh;
    }
    #frame {
      margin-top: 30px;
      width: 100%;
      height: 70vh;
      font-size: 0.8em;
      border-radius: 10px;
      margin-left: 3px;
      margin-right: 3px;
    }
  }

  .custom-dropdown-btn {
        /* background-color: white; */
        border: 1px solid grey;
    }
  #frame #sidepanel {
    float: left;
    min-width: 280px;
    max-width: 340px;
    width: 40%;
    height: 100%;
    background: #2c3e50;
    color: #f5f5f5;
    overflow: hidden;
    position: relative;
  }
  @media screen and (max-width: 735px) {
    #frame #sidepanel {
      width: 90px;
      min-width: 70px;
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
  @media screen and (max-width: 735px) {
    #frame #sidepanel #profile .wrap p {
      display: none;
    }
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
    line-height: initial !important;
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
    border: 2px solid #32465a !important;
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
    #frame #sidepanel #contacts ul li.contact .wrap .meta {
      display: none;
    }
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
      width: calc(100% - 90px);
      min-width: 200px !important;
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
      width: calc(100% - 340px);
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


@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap');

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
  width: 120px;
  margin-left: 6rem;
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

  </style>


  <style>
    /* **********************************
Reset CSS
************************************** */

html,
body,
div,
span,
applet,
object,
iframe,
h1,
h2,
h3,
h4,
h5,
h6,
p,
blockquote,
pre,
a,
abbr,
acronym,
address,
big,
cite,
code,
del,
dfn,
em,
img,
ins,
kbd,
q,
s,
samp,
small,
strike,
strong,
sub,
sup,
tt,
var,
b,
u,
i,
center,
dl,
dt,
dd,
ol,
ul,
li,
fieldset,
form,
label,
legend,
table,
caption,
tbody,
tfoot,
thead,
tr,
th,
td,
article,
aside,
canvas,
details,
embed,
figure,
figcaption,
footer,
header,
hgroup,
menu,
nav,
output,
ruby,
section,
summary,
time,
mark,
audio,
video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}


/* HTML5 display-role reset for older browsers */

article,
aside,
details,
figcaption,
figure,
footer,
header,
hgroup,
menu,
nav,
section {
    display: block;
}



ol,
ul {
    list-style: none;
}

blockquote,
q {
    quotes: none;
}

blockquote:before,
blockquote:after,
q:before,
q:after {
    content: '';
    content: none;
}

table {
    border-collapse: collapse;
    border-spacing: 0;
}


/********************************
 Typography Style
******************************** */

body {
    margin: 0;
    font-family: 'Open Sans', sans-serif;
    line-height: 1.5;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

html {
    min-height: 100%;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

h1 {
    font-size: 36px;
}

h2 {
    font-size: 30px;
}

h3 {
    font-size: 26px;
}

h4 {
    font-size: 22px;
}

h5 {
    font-size: 18px;
}

h6 {
    font-size: 16px;
}

p {
    font-size: 15px;
}

a {
    text-decoration: none;
    font-size: 15px;
}

* {
  margin-bottom: 0;
}


/* *******************************
message-area
******************************** */

.message-area {
    height: 90vh;
    overflow: hidden;
    padding: 30px 0;
    background: #f5f5f5;
    width: 70rem;
    border-radius:5px;
    margin-top: 5px;
}

@media screen and (max-width: 735px) {
  .message-area {
    height: 90vh;
    overflow: hidden;
    padding: 30px 0;
    background: #f5f5f5;
    width: 20rem;
    border-radius:5px;
    margin-top: 5px;
}
  }

.chat-area {
    position: relative;
    width: 100%;
    background-color: #fff;
    border-radius: 0.3rem;
    height: 90vh;
    overflow: hidden;
    min-height: calc(100% - 1rem);
}

.chatlist {
    outline: 0;
    height: 100%;
    overflow: hidden;
    width: 300px;
    float: left;
    padding: 15px;
}

.chat-area .modal-content {
    border: none;
    border-radius: 0;
    outline: 0;
    height: 100%;
}

.chat-area .modal-dialog-scrollable {
    height: 100% !important;
}

.chatbox {
    width: auto;
    overflow: hidden;
    height: 100%;
    border-left: 1px solid #ccc;
}

.chatbox .modal-dialog,
.chatlist .modal-dialog {
    max-width: 100%;
    margin: 0;
}

.msg-search {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chat-area .form-control {
    display: block;
    width: 80%;
    padding: 0.375rem 0.75rem;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    color: #222;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ccc;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.chat-area .form-control:focus {
    outline: 0;
    box-shadow: inherit;
}

a.add img {
    height: 36px;
}

.chat-area .nav-tabs {
    border-bottom: 1px solid #dee2e6;
    align-items: center;
    justify-content: space-between;
    flex-wrap: inherit;
}

.chat-area .nav-tabs .nav-item {
    width: 100%;
}

.chat-area .nav-tabs .nav-link {
    width: 100%;
    color: #180660;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
    text-transform: capitalize;
    margin-top: 5px;
    margin-bottom: -1px;
    background: 0 0;
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.chat-area .nav-tabs .nav-item.show .nav-link,
.chat-area .nav-tabs .nav-link.active {
    color: #222;
    background-color: #fff;
    border-color: transparent transparent #000;
}

.chat-area .nav-tabs .nav-link:focus,
.chat-area .nav-tabs .nav-link:hover {
    border-color: transparent transparent #000;
    isolation: isolate;
}

.chat-list h3 {
    color: #222;
    font-size: 16px;
    font-weight: 500;
    line-height: 1.5;
    text-transform: capitalize;
    margin-bottom: 0;
}

.chat-list p {
    color: #343434;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    text-transform: capitalize;
    margin-bottom: 0;
}

.chat-list a.d-flex {
    margin-bottom: 15px;
    position: relative;
    text-decoration: none;
}

.chat-list .active {
    display: block;
    content: '';
    clear: both;
    position: absolute;
    bottom: 3px;
    left: 34px;
    height: 12px;
    width: 12px;
    background: #00DB75;
    border-radius: 50%;
    border: 2px solid #fff;
}

.msg-head h3 {
    color: #222;
    font-size: 18px;
    font-weight: 600;
    line-height: 1.5;
    margin-bottom: 0;
}

.msg-head p {
    color: #343434;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    text-transform: capitalize;
    margin-bottom: 0;
}

.msg-head {
    padding: 15px;
    border-bottom: 1px solid #ccc;
}

.moreoption {
    display: flex;
    align-items: center;
    justify-content: end;
}

.moreoption .navbar {
    padding: 0;
}

.moreoption li .nav-link {
    color: #222;
    font-size: 16px;
}

.moreoption .dropdown-toggle::after {
    display: none;
}

.moreoption .dropdown-menu[data-bs-popper] {
    top: 100%;
    left: auto;
    right: 0;
    margin-top: 0.125rem;
}

.msg-body ul {
    overflow: hidden;
}

.msg-body ul li {
    list-style: none;
    margin: 15px 0;
}

.msg-body ul li.sender {
    display: block;
    width: 100%;
    position: relative;
}

.msg-body ul li.sender:before {
    display: block;
    clear: both;
    content: '';
    position: absolute;
    top: -6px;
    left: -7px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 12px 15px 12px;
    border-color: transparent transparent #f5f5f5 transparent;
    -webkit-transform: rotate(-37deg);
    -ms-transform: rotate(-37deg);
    transform: rotate(-37deg);
}

.msg-body ul li.sender p {
    color: #000;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 400;
    padding: 15px;
    background: #f5f5f5;
    display: inline-block;
    border-bottom-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    margin-bottom: 0;
}

.msg-body ul li.sender p b {
    display: block;
    color: #180660;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 500;
}

.msg-body ul li.repaly {
    display: block;
    width: 100%;
    text-align: right;
    position: relative;
}

.msg-body ul li.repaly:before {
    display: block;
    clear: both;
    content: '';
    position: absolute;
    bottom: 15px;
    right: -7px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 12px 15px 12px;
    border-color: transparent transparent #4b7bec transparent;
    -webkit-transform: rotate(37deg);
    -ms-transform: rotate(37deg);
    transform: rotate(37deg);
}

.msg-body ul li.repaly p {
    color: #fff;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 400;
    padding: 15px;
    background: #4b7bec;
    display: inline-block;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 10px;
    margin-bottom: 0;
}

.msg-body ul li.repaly p b {
    display: block;
    color: #061061;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 500;
}

.msg-body ul li.repaly:after {
    display: block;
    content: '';
    clear: both;
}

.time {
    display: block;
    color: #000;
    font-size: 12px;
    line-height: 1.5;
    font-weight: 400;
}

li.repaly .time {
    margin-right: 20px;
}

.divider {
    position: relative;
    z-index: 1;
    text-align: center;
}

.msg-body h6 {
    text-align: center;
    font-weight: normal;
    font-size: 14px;
    line-height: 1.5;
    color: #222;
    background: #fff;
    display: inline-block;
    padding: 0 5px;
    margin-bottom: 0;
}

.divider:after {
    display: block;
    content: '';
    clear: both;
    position: absolute;
    top: 12px;
    left: 0;
    border-top: 1px solid #EBEBEB;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.send-box {
    padding: 15px;
    border-top: 1px solid #ccc;
}

.send-box form {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
}

.send-box .form-control {
    display: block;
    width: 85%;
    padding: 0.375rem 0.75rem;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    color: #222;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ccc;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.send-box button {
    border: none;
    background: #3867d6;
    padding: 0.375rem 5px;
    color: #fff;
    border-radius: 0.25rem;
    font-size: 14px;
    font-weight: 400;
    width: 24%;
    margin-left: 1%;
}

.send-box button i {
    margin-right: 5px;
}

.send-btns .button-wrapper {
    position: relative;
    width: 125px;
    height: auto;
    text-align: left;
    margin: 0 auto;
    display: block;
    background: #F6F7FA;
    border-radius: 3px;
    padding: 5px 15px;
    float: left;
    margin-right: 5px;
    margin-bottom: 5px;
    overflow: hidden;
}

.send-btns .button-wrapper span.label {
    position: relative;
    z-index: 1;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    width: 100%;
    cursor: pointer;
    color: #343945;
    font-weight: 400;
    text-transform: capitalize;
    font-size: 13px;
}

#upload {
    display: inline-block;
    position: absolute;
    z-index: 1;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}

.send-btns .attach .form-control {
    display: inline-block;
    width: 120px;
    height: auto;
    padding: 5px 8px;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.5;
    color: #343945;
    background-color: #F6F7FA;
    background-clip: padding-box;
    border: 1px solid #F6F7FA;
    border-radius: 3px;
    margin-bottom: 5px;
}

.send-btns .button-wrapper span.label img {
    margin-right: 5px;
}

.button-wrapper {
    position: relative;
    width: 100px;
    height: 100px;
    text-align: center;
    margin: 0 auto;
}

button:focus {
    outline: 0;
}

.add-apoint {
    display: inline-block;
    margin-left: 5px;
}

.add-apoint a {
    text-decoration: none;
    background: #F6F7FA;
    border-radius: 8px;
    padding: 8px 8px;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.2;
    color: #343945;
}

.add-apoint a svg {
    margin-right: 5px;
}

.chat-icon {
    display: none;
}

.closess i {
    display: none;
}



@media (max-width: 767px) {
    .chat-icon {
        display: block;
        margin-right: 5px;
    }
    .chatlist {
        width: 100%;
    }
    .chatbox {
        width: 100%;
        position: absolute;
        left: 1000px;
        right: 0;
        background: #fff;
        transition: all 0.5s ease;
        border-left: none;
    }
    .showbox {
        left: 0 !important;
        transition: all 0.5s ease;
    }
    .msg-head h3 {
        font-size: 14px;
    }
    .msg-head p {
        font-size: 12px;
    }
    .msg-head .flex-shrink-0 img {
        height: 30px;
    }
    .send-box button {
        width: 28%;
    }
    .send-box .form-control {
        width: 70%;
    }
    .chat-list h3 {
        font-size: 14px;
    }
    .chat-list p {
        font-size: 12px;
    }
    .msg-body ul li.sender p {
        font-size: 13px;
        padding: 8px;
        border-bottom-left-radius: 6px;
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
    }
    .msg-body ul li.repaly p {
        font-size: 13px;
        padding: 8px;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        border-bottom-left-radius: 6px;
    }
}
  </style>
  @livewireScripts
  @livewireStyles
@endsection
@section('main-container')
{{ $slot }}
<script>
    jQuery(document).ready(function() {
        $(".chat-list a").click(function() {
          console.log('hey');
            $(".chatbox").addClass('showbox');
            return false;
        });

        $(".chat-icon").click(function() {
            $(".chatbox").removeClass('showbox');
        });
    });
</script>
@endsection