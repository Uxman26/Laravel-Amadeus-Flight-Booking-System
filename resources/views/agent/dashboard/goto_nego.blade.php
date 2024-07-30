@extends('layouts.app')
@section('content')
    <section class="">
        <div class="">
            {{-- <iframe id="myiFrame" allowtransparency="true" allow="geolocation *;"
                sandbox="allow-same-origin allow-presentation allow-scripts allow-forms allow-popups allow-popups-to-escape-sandbox"
                width="100%" style="height:550px" src="https://www.toptraveltrip.com/dashboard/dashboardHomes"></iframe> --}}
                <form id="login" target="frame" method="POST" action="https://www.toptraveltrip.com/loginAction">
                    <input type="hidden" name="selectLang" value="en" />
                    <input type="hidden" name="selectLangString" value="en" />
                    <input type="hidden" name="userAa" value="" />
                    <input type="hidden" name="userDis" value="" />
                    <input type="hidden" name="old_login_flag" value='true' />
                    <input type="hidden" name="isAWSGoogleAuthUser" value="" />
                    <input type="hidden" name="awsPassVerifyFlag" value="" />
                    <input type="hidden" name="awsOtpVerifyFlag" value="" />
                    <input type="hidden" name="displayUserType" value="AGN21004" />
                    <input type="hidden" name="userAlias" value="travelgondal@gmail.com" />
                    <input type="hidden" name="password" value="dubai@123PARIS" />
                </form>
                
                <iframe sandbox="allow-same-origin allow-presentation allow-scripts allow-forms allow-popups allow-popups-to-escape-sandbox" width="100%" style="height:550px" id="frame" name="frame"></iframe>
                

        </div>
    </section>

    {{-- <script>
        $(document).ready(function() {
            if (window.self !== window.top) {
                $('#agencyCodeMain').css('display','none');
            }
        })
    </script> --}}
    <script type="text/javascript">
        // submit the form into iframe for login into remote site
        document.getElementById('login').submit();
    </script>
@endsection