<x-header />
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mx-auto">
                <div class="section-title">
                    <h2>Create new account</h2>
                </div>
                <div class="contact__form">
                    <form action="{{ URL::to('/registerUser') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- <p>Cross-Site Request Forgery token.
                                            This token helps ensure that the form submission is coming
                                            from the authenticated user and not from a malicious site.</p> -->
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" placeholder="Name" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="Email">
                            </div>
                            <div class="col-lg-12">
                                <input type="file" name="file" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="password" name="password" placeholder="Password">
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" name="register" class="site-btn">Sign up</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<x-footer />
