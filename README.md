WordPress OSDI Signup Plugin
==============

This project is co-managed by [NOI Labs](http://neworganizing.com/labs) and OSDI

WordPress OSDI signup form.  Supports insertion to multiple CRMs per submission

Usage
=====

## Configuration

Copy and customize config.sample.php to your liking.

## Form
Create a form on your site, styled as you wish, with the appropriately named inputs.

````html
<div class="signupss">
                        <form role="form" id="osdi-form" action="/osdi" method="POST">
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control" id="osdi-email" placeholder="Enter email" name="osdi-email" style="cursor: pointer; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
                            </div>

                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" id="osdi-given-name" placeholder="First Name" name="osdi-given-name">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" id="osdi-family-name" placeholder="Last Name" name="osdi-family-name">
                            </div>
                            <div class="form-group">
                                <label>Mobile Phone</label>
                                <input type="text" class="form-control" id="osdi-mobile-phone" placeholder="Mobile Phone" name="osdi-phone">
                            </div>


                            <div class="form-group">
                                <label>Address1</label>
                                <input type="text" class="form-control" id="osdi-address1" placeholder="Address 1" name="osdi-address1">
                            </div>
                            <div class="form-group">
                                <label>Address2</label>
                                <input type="text" class="form-control" id="osdi-address2" placeholder="Address 2" name="osdi-address2">
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" id="osdi-locality" placeholder="City" name="osdi-locality">
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" class="form-control" id="osdi-region" placeholder="State" name="osdi-region">
                            </div>
                            <div class="form-group">
                                <label>Zip</label>
                                <input type="text" class="form-control" id="osdi-postal-code" placeholder="Zip" name="osdi-postal-code">
                            </div>

                            <div class="form-group checkbox">
                                <label>
                                    <input class="tags" id="volunteer" value="volunteer" type="checkbox"> I want to
                                    Volunteer
                                </label>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-warning" id="osdi-signup">Submit</button>
                                <button type="button" class="btn btn-default" id="test-fill">Test Fill</button>
                            </div>
                        </form>
                    </div>
                   
````

