<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Application</title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="~/../libs/bootstrap/css/bootstrap.css">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <!-- defer = run after page load -->
    <script src="~/../libs/jquery.min.js"></script>           
    <script src="~/../libs/bootstrap/js/bootstrap.js" defer></script>    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style type="text/css">
        .wrapper{
            width: 90%;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }

        body {
            margin: 0;
            font-family: var(--bs-font-sans-serif);
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: transparent;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
        .lead {
            font-size: 1.25rem;
            font-weight: 100;
            font-size: large;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
        }
        .help-block {            
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
        }
        .text-special {
            color: #f00 !important;
        }
        .g-recaptcha {
            display: inline-block;
        }
    </style>
    
</head>
<body class="bg-light">
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="py-5 text-center">
                        <h2>Online Application</h2>                        
                        <p class="lead">Submit your applications online</p>                   
                    </div>
                                        
                    <form action="index.php?act=add" method="post" class="row g-3 needs-validation" novalidate>

                        <div class="row gy-3">
                            <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="" value="">
                            <div class="invalid-feedback">
                                First name is required.
                            </div>                            
                            </div>

                            <div class="col-sm-6">
                            <label for="lastname" class="form-label">Last name<span class="text-special">*</span></label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Last name is required.
                            </div>                                                                                
                            </div>
                       
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email<span class="text-special">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="" required="">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="">                            
                            </div>  
                     
                            
                  
                            <div class="col-md-6">
                                <label for="education" class="form-label">Education<span class="text-special">*</span></label>
                                <select class="form-select" id="education" name="education" required="">
                                    <option value="">Choose...</option>
                                    <option value="1"> Software Engineering </option>
                                    <option value="2"> Information Technology </option>
                                    <option value="3"> Computer Science </option>
                                    <option value="4"> Computer Applications </option>
                                    <option value="5"> Others </option>                                    
                                </select>
                                <div class="invalid-feedback">
                                    Please select an education.
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label">Education Level<span class="text-special">*</span></label>
                                <select class="form-select" id="edu_level" name="edu_level" required="">
                                    <option value="">Choose...</option>
                                    <option value="1"> Post Graduate </option>
                                    <option value="2"> Under Graduate </option>
                                    <option value="3"> Diploma </option>
                                    <option value="4"> Others </option>                                                                        
                                </select>
                                <div class="invalid-feedback">
                                    Please select an education level.
                                </div>                                
                            </div>
                    
                      
                       
                            <div class="col-md-6">
                                <label for="industry" class="form-label">Industry<span class="text-special">*</span></label>
                                <select class="form-select" id="industry" name="industry" required="">
                                    <option value="">Choose...</option>
                                    <option value="1"> Software Engineering </option>
                                    <option value="2"> QA Automation </option>
                                    <option value="3"> Database administration </option>
                                    <option value="4"> System Administration </option>
                                    <option value="5"> N/A </option>                                    
                                </select>
                                <div class="invalid-feedback">
                                    Please select an industry.
                                </div>                               
                            </div>
                            <div class="col-md-6" id="work_exp_div">
                                <label for="work_exp" class="form-label">Work Experience<span class="text-special">*</span></label>
                                <select class="form-select" id="work_exp" name="work_exp" required="">
                                    <option value="">Choose...</option>
                                    <option value="1"> 1 Yr </option>
                                    <option value="2"> 2 Yrs </option>
                                    <option value="3"> 3 Yrs </option>
                                    <option value="4"> 4 Yrs </option>
                                    <option value="5"> 5 Yrs </option>
                                    <option value="6"> 6 Yrs </option>
                                    <option value="7"> More than 6 Yrs </option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a work experience.
                                </div>                                
                            </div>
                        </div>
                        <div class="row gy-3"> 
                            <div class="col text-center">
                                <div class="g-recaptcha" data-sitekey="6LfcAFcbAAAAAJyDh5z5Crtydl62eR3iWUj4OVW8"></div>
                            </div>
                        </div>
                        <div class="row gy-3">                            
                            <div class="col text-center">
                                <input type="submit" name="addbtn" class="btn btn-primary" value="Submit">  
                            </div>  
                        </div>                    
                    </form>
                </div>
            </div>        
        </div>
    </div>

    
    <script type="text/javascript">
        $(document).ready(function(){
            (function () {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.querySelectorAll('.needs-validation')

                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()

            $("#industry").change(function(){
                if ($(this).val() == '5') {
                    $("#work_exp_div").hide();
                    $('#work_exp').prop('required',false);
                } else {
                    $("#work_exp_div").show();
                    $('#work_exp').prop('required',true);
                }          
            });
        });
         
    </script>
</body>
</html>