<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Webhosting Membership Application</title>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <style>
            body {
                font-family: Calibri;
                margin-left: 50px;
            }
            input{
                padding: 5px;
            }

            input.scrunch {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Membership Application</h1>
        <p>To apply for membership, please complete all questions</p>
        <?php
            /*
                What do I plan to validate?
                I want to make sure:
                    people are using an appropriate email address <>
                    once a person is registered, tell them which membership they have <>
                I would like store membership info
            */
            // declare variables
            $filename = "members.txt";
            $file = fopen($filename,"a") or die("can't open file");
            $member_info = "";
            chmod($filename,0666);
            $in_us = true;
            $error = false;
            $error_msg = "Your form could not be submitted due to an error: ";
            $submitted = false;

            if (isset($_POST["submit"])) { //when form submitted
                //store all values from POST autoglobal
                $fname = $_POST["fname"];
                $lname = $_POST["lname"];
                $email = $_POST["email"];
                $street = $_POST["street"];
                $city = $_POST["city"];
                $state = $_POST["state"];
                $zip = $_POST["zip"];
                $country = $_POST["country"];
                $website = $_POST["website"];
                $phone = $_POST["phone"];
                $mem_type = $_POST["mem_type"];

                //for debugging purposes
                /*echo "<p>$fname</p><br />
                <p>$lname</p><br />
                <p>$email</p><br />
                <p>$street</p><br />
                <p>$city</p><br />
                <p>$state</p><br />
                <p>$zip</p><br />
                <p>$country</p><br />
                <p>$website</p><br />
                <p>$phone</p><br />
                <p>$mem_type</p><br />";*/

                // if user outside of US, inform them that we cannot help them and make sure the form does not submit info to server
                if ($country != "United States of America") {
                    echo "<p>We're sorry to say, but we cannot provide memberships outside of the US</p><br />";
                    $in_us = false;
                }

                // if in us, then continue form submission/validation
                if ($in_us) {
                    do { // execute loop once, break wwhen an error arises or form submitted
                        if ($fname == "") {
                            $error = true;
                            $error_msg = $error_msg . "You must enter your first name";
                            continue;
                        }
                        else {
                            $member_info .= $fname . ",";
                        }

                        if ($lname == "") {
                            $error = true;
                            $error_msg = $error_msg . "You must enter your last name";
                            continue;
                        }
                        else {
                            $member_info .= $lname . ",";
                        }

                        if ($email == "") {
                            $error = true;
                            $error_msg .= "You must enter your email address";
                            continue;
                        }
                        elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                            $error = true;
                            $error_msg .= "You have entered an invalid email address";
                            continue;
                        }
                        else {
                            $member_info .= $email . ",";
                        }

                        if ($street == "") {
                            $error = true;
                            $error_msg .= "Please enter a street address";
                            continue;
                        }
                        else {
                            $member_info .= $street . ",";
                        }

                        if ($city == "") {
                            $error = true;
                            $error_msg .= "Please enter a city";
                            continue;
                        }
                        else {
                            $member_info .= $city . ",";
                        }

                        if ($state == "Please Select One") {
                            $error = true;
                            $error_msg .= "Please select a state";
                            continue;
                        }
                        else {
                            $member_info .= $state . ",";
                        }

                        if (empty($zip)) {
                            $error = true;
                            $error_msg .= "Please enter a zip code";
                            continue;
                        }
                        elseif (!is_numeric($zip) || strlen($zip) != 5) {
                            $error = true;
                            $error_msg .= "Please enter a valid 5-digit zip code (numbers only)";
                        }
                        else {
                            $member_info .= $zip . ",";
                        }

                        if ($website == "") {
                            $error = true;
                            $error_msg .= "Please enter a url for your website";
                        }
                        elseif (!filter_var($website,FILTER_VALIDATE_URL)) {
                            $error = true;
                            $error_msg .= "Please enter a valid url (Format: http://www.websitename.com)";
                        }
                        else {
                            $member_info .= $website . "," . $phone . "," . $mem_type . "\r\n";
                            $submitted = true;
                        }
                    } while(!$error && !$submitted);
                    if ($error) { //if error arises, output to user
                        echo "<p>$error_msg</p><br />";
                    }
                    else {
                        if (fwrite($file,$member_info) > 0) { // If form submitted, tell user it was a success and write to file
                            echo "<p>Your application has successfully been submitted. You have registered for the $mem_type Membership!</p><br />";
                        }
                    }
                }
            }
            fclose($file);
        ?>
        <h2>Register Here</h2>
        <form action="GalvezFinal.php" method="POST">
            <h3>Name</h3>
            <label for="fname">First Name:</label> <input style="margin-right: 50px" type="text" id="fname" name="fname" autofocus/>
            <label for="lname">Last Name:</label> <input type="text" id="lname" name="lname" /> <br />
            <h3>E-Mail</h3>
            <input type="text" name="email" placeholder="ex: myname@example.com"/> <br />
            <h3>Address</h3>
            <label for="street">Street Address:</label> <input class="scrunch" type="text" id="street" name="street" /> <br />
            <label for="city">City:</label> <input class="scrunch" style="margin-right: 127px" type="text" id="city" name="city" />
            State/Territory: 
            <select name="state">
                <option value="Please Select One">Please Select One</option>
                <option value="Alabama">Alabama</option>
                <option value="Alaska">Alaska</option>
                <option value="Arizona">Arizona</option>
                <option value="Arkansas">Arkansas</option>
                <option value="California">California</option>
                <option value="Colorado">Colorado</option>
                <option value="Connecticut">Connecticut</option>
                <option value="Delaware">Delaware</option>
                <option value="Florida">Florida</option>
                <option value="Georgia">Georgia</option>
                <option value="Hawaii">Hawaii</option>
                <option value="Idaho">Idaho</option>
                <option value="Illinois">Illinois</option>
                <option value="Indiana">Indiana</option>
                <option value="Iowa">Iowa</option>
                <option value="Kansas">Kansas</option>
                <option value="Kentucky">Kentucky</option>
                <option value="Louisiana">Louisiana</option>
                <option value="Maine">Maine</option>
                <option value="Maryland">Maryland</option>
                <option value="Massachusetts">Massachusetts</option>
                <option value="Michigan">Michigan</option>
                <option value="Minnesota">Minnesota</option>
                <option value="Mississippi">Mississippi</option>
                <option value="Missouri">Missouri</option>
                <option value="Montana">Montana</option>
                <option value="Nebraska">Nebraska</option>
                <option value="Nevada">Nevada</option>
                <option value="New Hampshire">New Hampshire</option>
                <option value="New Jersey">New Jersey</option>
                <option value="New Mexico">New Mexico</option>
                <option value="New York">New York</option>
                <option value="North Carolina">North Carolina</option>
                <option value="North Dakota">North Dakota</option>
                <option value="Ohio">Ohio</option>
                <option value="Oklahoma">Oklahoma</option>
                <option value="Oregon">Oregon</option>
                <option value="Pennsylvania">Pennsylvania</option>
                <option value="Rhode Island">Rhode Island</option>
                <option value="South Carolina">South Carolina</option>
                <option value="South Dakota">South Dakota</option>
                <option value="Tennessee">Tennessee</option>
                <option value="Texas">Texas</option>
                <option value="Utah">Utah</option>
                <option value="Vermont">Vermont</option>
                <option value="Virginia">Virginia</option>
                <option value="Washington">Washington</option>
                <option value="West Virginia">West Virginia</option>
                <option value="Wisconsin">Wisconsin</option>
                <option value="Wyoming">Wyoming</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Guam">Guam</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="US Virgin Islands">US Virgin Islands</option>
            </select>
            <br />
            <label for="zip">Postal/Zip Code:</label> <input class="scrunch" style="margin-right: 50px" type="text" id="zip" name="zip" />
            Country: 
            <select name="country">
                <option value="Afghanistan">Afghanistan</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Brazil">Brazil</option>
                <option value="Brunei">Brunei</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                <option value="Cabo Verde">Cabo Verde</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Greece">Greece</option>
                <option value="Grenada">Grenada</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-Bissau">Guinea-Bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Holy See">Holy See</option>
                <option value="Honduras">Honduras</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran">Iran</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Laos">Laos</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libya">Libya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macedonia (FYROM)">Macedonia (FYROM)</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia">Micronesia</option>
                <option value="Moldova">Moldova</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar (formerly Burma)">Myanmar (formerly Burma)</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="North Korea">North Korea</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestine State">Palestine State</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Qatar">Qatar</option>
                <option value="Romania">Romania</option>
                <option value="Russia">Russia</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Korea">South Korea</option>
                <option value="South Sudan">South Sudan</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syria">Syria</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania">Tanzania</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-Leste">Timor-Leste</option>
                <option value="Togo">Togo</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States of America" selected>United States of America</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
            </select>
            <br />
            <h3>Website</h3>
            <input type="text" name="website" placeholder="ex: https://www.websitename.com" size="40"/> <br />
            <h3>Phone Number</h3>
            <input type="tel" name="phone" pattern=".[0-9]{3}.\s[0-9]{3}-[0-9]{4}" placeholder="Format: (___) ___-____" /> <br />
            <h3>Membership Type</h3>
            <input type="radio" name="mem_type" value="1 Year" checked/>1 Year Membership $100.00 <br />
            <input type="radio" name="mem_type" value="5 Year" />5 Year Membership $200.00 <br /> <br />

            <input type="submit" name="submit" value="Apply for Membership" /> 
        <form>
    </body>
</html>


