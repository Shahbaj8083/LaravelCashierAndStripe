<x-header />
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mx-auto">
                <div class="section-title">
                    <h2>Buy plan</h2>
                </div>
                <div class="contact__form">
                    <form method="POST" action="{{ route('plans.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Plan Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter email">
                            </div>
                            <div class="col-lg-6">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                            </div>
                            <div class="col-lg-6">
                                <label>Currency</label>
                                <input type="text" name="currency" class="form-control" placeholder="Enter currency">
                            </div>
                            <div class="col-lg-6">
                                <label>Interval Count</label>
                                <input type="number" name="interval_count" class="form-control"
                                    placeholder="Enter count">
                            </div>
                            <div class="col-lg-12">
                                <label>Billing Period</label><br>
                                <select name="billing_period" class="form-control">
                                    <option disabled selected>Choose billing method</option>
                                    <option value="week">Weekly</option>
                                    <option value="month">Monthly</option>
                                    <option value="year">Yearly</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <button type="submit" class="site-btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<x-footer />
