WordPress OSDI Signup Plugin
==============
![](osdi.square.png)
This project is co-managed by [NOI Labs](http://neworganizing.com/labs) and OSDI

WordPress OSDI signup form.  Supports insertion to multiple CRMs per submission as enhancer functionality.

More information about OSDI can be found here: [opensupporter.org](http://opensupporter.org)

Usage
=====

## Configuration

Once installed, set plugin configuration to your liking.  See below for examples of the server config yaml.

````
# This config uses accurate append to enhance the data we got from the signup form and then pushes the enhanced (merged) version into Action Network

servers:
   - name: 'Accurate Append'
     url: accurate_url
     api_token: accurate_api_token
     enabled: true
     mode: enhancer

   - name: "Action Network"
     url: "https://actionnetwork.org/api/v2/people"
     api_token: "APIKEY"
     enabled: true
     mode: store

redirect:
    success_url: "http://localhost/thank-you"
    fail_url: "http://localhost/error"

originating_system: "wp-signup-plugin"
````

## Form
Create a form on your site, styled as you wish, with the appropriately named inputs.

````html
<div class="signupss">
    <form role="form" id="osdi-form" action="/osdi" method="POST">
        <div class="form-group">
            <label>Email address</label>
            <input type="email" class="form-control" id="osdi-email" placeholder="Enter email" name="osdi-email">
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

## Enjoy OSDI magic

License
=======

MIT

Maintainers
===========
Josh Cohen, @joshco
Open Supporter Data Interface
http://opensupporter.org
