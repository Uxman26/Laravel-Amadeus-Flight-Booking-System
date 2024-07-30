<style>
    * {
        font-family: "Arial", sans-serif;
    }

    .whatsapp-fixed {
        position: fixed;
        bottom: 40px;
        right: 62px;
        z-index: 9;
    }

    .btn-whatsapp {
        background-color: #30bf39;
        color: #fff;
        border-radius: 100%;
        transition: background-color .5s;
        width: 60px !important;
        height: 60px !important;
        line-height: 70px;
        position: relative !important;
        display: block;
        transform: none !important;
        z-index: 9;
        text-align: center;
        box-shadow:
            0 1px 2px rgba(0, 0, 0, 0.07),
            0 2px 4px rgba(0, 0, 0, 0.07),
            0 4px 8px rgba(0, 0, 0, 0.07),
            0 8px 16px rgba(0, 0, 0, 0.07),
            0 16px 32px rgba(0, 0, 0, 0.07),
            0 32px 64px rgba(0, 0, 0, 0.07);
    }

    .btn-whatsapp:hover {
        background-color: #53ca5b;
    }

    .whatsapp-fixed a.video-vemo-icon.btn-whatsapp i {
        font-size: 32px;
        color: #fff;
        animation: sm-shake-animation linear 1.5s infinite;
        animation-delay: 3s;
    }

    .rs-video .animate-border .video-vemo-icon:before {
        content: "";
        border: 2px solid #fff;
        position: absolute;
        z-index: 0;
        left: 50%;
        top: 50%;
        opacity: 0;
        transform: translateX(-50%) translateY(-50%);
        display: block;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        animation: zoomBig 3.25s linear infinite;
        -webkit-animation-delay: 4s;
        animation-delay: 4s;
    }

    .rs-video .animate-border .video-vemo-icon:after {
        content: "";
        border: 2px solid #fff;
        position: absolute;
        opacity: 0;
        z-index: 0;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
        display: block;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        animation: zoomBig 3.25s linear infinite;
        -webkit-animation-delay: 3s;
        animation-delay: 3s;
    }

    .btn-whatsapp:after,
    .btn-whatsapp:before {
        border: 2px solid #30bf39 !important;
        width: 130px !important;
        height: 130px !important;
    }

    .sm-red-dot {
        position: absolute;
        right: 4px;
        top: 4px;
        width: 12px;
        height: 12px;
        margin: 0 auto;
        background: red;
        transform: scale(0);
        border-radius: 50%;
        animation-name: notificationPoint;
        animation-duration: 300ms;
        animation-fill-mode: forwards;
        animation-delay: 3s;
    }

    .quick-message {
        position: absolute;
        bottom: 4px;
        right: 88px;
        width: max-content;
        border-radius: 0;
        background: #393b39;
    }

    .line-up {
        opacity: 0;
        animation-name: anim-lineUp;
        animation-duration: 0.75s;
        animation-fill-mode: forwards;
        animation-delay: 5s;
    }

    .quick-message p {
        line-height: 40px;
        font-size: 15px;
        padding: 4px 16px;
        height: 40px;
        position: relative;
        color: #fff;
        margin: 0;
    }

    .quick-message .seta-direita:before {
        display: inline-block;
        content: "";
        vertical-align: middle;
        margin-right: 10px;
        width: 0;
        height: 0;
        border-top: 20px solid transparent;
        border-bottom: 20px solid transparent;
        border-left: 20px solid #393b39;
        position: absolute;
        bottom: 3px;
        right: -30px;
    }

    #hover-message {
        display: none;
    }

    .whatsapp-fixed:hover #hover-message {
        display: block;
    }

    @keyframes zoomBig {
        0% {
            transform: translate(-50%, -50%) scale(.5);
            opacity: 1;
            border-width: 3px
        }

        40% {
            opacity: .5;
            border-width: 2px
        }

        65% {
            border-width: 1px
        }

        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0;
            border-width: 1px
        }
    }

    @keyframes sm-shake-animation {
        0% {
            transform: rotate(0) scale(1) skew(0.017rad)
        }

        25% {
            transform: rotate(0) scale(1) skew(0.017rad)
        }

        35% {
            transform: rotate(-0.3rad) scale(1) skew(0.017rad)
        }

        45% {
            transform: rotate(0.3rad) scale(1) skew(0.017rad)
        }

        55% {
            transform: rotate(-0.3rad) scale(1) skew(0.017rad)
        }

        65% {
            transform: rotate(0.3rad) scale(1) skew(0.017rad)
        }

        75% {
            transform: rotate(0) scale(1) skew(0.017rad)
        }

        100% {
            transform: rotate(0) scale(1) skew(0.017rad)
        }
    }

    @keyframes notificationPoint {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    @keyframes anim-lineUp {
        from {
            transform: translateY(100%);
        }

        to {
            opacity: 1;
            transform: translateY(0%);
        }
    }
</style>
<div class="rs-video whatsapp-fixed">
    <div class="animate-border">
        <a alt="Whatsapp" class="video-vemo-icon btn-whatsapp" aria-label="WhatsApp"
            href="https://api.whatsapp.com/send?phone=33771626271&amp;text=Hello%20Gondal,%20Having%20visited%20your%20website,%20I%20would%20like%20to%20know%20more%20about%20tickets%20and%C2%A0umrah%C2%A0packages." target="_blank" rel="noopener noreferrer"
            onclick="gtag_report_conversion(undefined)"><i class="fab fa-whatsapp"></i>
            <div class="sm-red-dot"></div>
            <div id="quick-message" class="quick-message line-up">
                <p>
                    24/7 customer service team
                </p>
                <div class="seta-direita">
                </div>
            </div>
        </a>
    </div>
    <div id="hover-message" class="quick-message">
        <p>
            Feel free to reach out to us
        </p>
        <div class="seta-direita">
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        $('#quick-message').slideUp(300, function() {
            $(this).remove();
        });
    }, 10000);
</script>
