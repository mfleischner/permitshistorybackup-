@include('includes.header')

  <main id="main">


        <!--Section-Policy-->

        <section class="about Policy">
            <div class="container">
                {{ Breadcrumbs::render('about-us') }}

                <div class="heading-section">
                    <h2>About Us</h2>
                </div>


                <div class="grid Policy-grid">
                    <h4>PermitSearch.com was created to safeguard the process of buying and selling a home.</h4>
                    <p>The moving process can be intimidating.  There are many steps involved.  One of those steps is to secure the information regarding any permits on the property.  Too often, discovery of open permits can derail the sale.</p>
                    <h4>PermitSearch.com is here to help.</h4>
                    <p>PermitSearch.com obtains the permit information for you and presents it in a clear format so that you can plan your next steps going forward.</p>
                    <h4>PermitSearch.com eliminates any permit surprises.</h4>
                    <p>PermitSearch.com was developed by real estate professionals who have years of transactions know-how and who have experienced first-hand the difficulties and delays posed by unknown open permits.</p>
                    <h4>PermitSearch.com gets any open permits out in the open.</h4>
                    <p><a href="{{url("/")}}">Click here to get started.</a></p>

                </div>
                <div class="grid Policy-grid text-center">
                    <h4>Welcome to PermitSearch.com</h4>
                    <p>Buying or selling a home?</p>
                    <p>Search for permit history here.</p>
                </div>
                <div class="grid Policy-grid">
                    <h4>Step 1</h4>
                    <p>Enter complete property address. <br>
                        Include house number, street address, apartment/suite, town, and zip code. </p>
                    <h4>Step 2</h4>
                    <p>Order permit history by simply clicking a button.</p>
                    <h4>Step 3</h4>
                    <p>You will be notified when your permit history is available. <br> You will be able to download and/or print your results.</p>

                </div>


            </div>
        </section>

        <!--Section-Policy-End-->


    </main>

@include('includes.footer')
