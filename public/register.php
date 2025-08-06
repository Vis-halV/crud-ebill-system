<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - EBMS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Enhanced styling for registration form */
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .form-group.full-width {
            flex: 100%;
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 5px;
            align-items: center;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .radio-option input[type="radio"] {
            margin: 0;
        }
        
        .radio-option label {
            margin: 0;
            font-weight: normal;
            cursor: pointer;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #45a049;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4CAF50;
        }
        
        .form-header h1 {
            color: #4CAF50;
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: #666;
            margin: 0;
        }
        
        .required {
            color: #dc3545;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
            
            .container {
                width: 90%;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>

<?php include('header.html'); ?>

<div class="container">
    <div class="form-header">
        <h1>Customer Registration</h1>
        <p>Please fill in all the required information to register a new customer</p>
    </div>
    
    <form action="submit.php" method="POST">
        <!-- Name Fields -->
        <div class="form-row">
            <div class="form-group">
                <label for="customer_name">First Name <span class="required">*</span></label>
                <input type="text" id="customer_name" name="customer_name" placeholder="Enter first name" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" placeholder="Enter last name">
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="form-row">
            <div class="form-group">
                <label for="contact_number">Contact Number <span class="required">*</span></label>
                <input type="tel" id="contact_number" name="contact_number" placeholder="e.g., +1-234-567-8900" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email" placeholder="example@email.com" required>
            </div>
        </div>
        
        <!-- Address -->
        <div class="form-row">
            <div class="form-group full-width">
                <label for="address">Complete Address <span class="required">*</span></label>
                <textarea id="address" name="address" rows="3" placeholder="Enter complete address including street, city, state, ZIP code" required></textarea>
            </div>
        </div>
        
        <!-- Connection Type -->
        <div class="form-row">
            <div class="form-group full-width">
                <label>Connection Type <span class="required">*</span></label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="public" name="connecttype" value="public" required>
                        <label for="public">Public/Residential</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="commercial" name="connecttype" value="commercial" required>
                        <label for="commercial">Commercial/Business</label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Register Customer</button>
            <a href="view_customers.php" class="btn btn-secondary">View All Customers</a>
        </div>
    </form>
    
    <div style="text-align: center; margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
        <p><strong>Note:</strong> Fields marked with <span class="required">*</span> are required.</p>
        <p>After registration, you can set up the customer's meter in the <a href="meter_setup.php" style="color: #4CAF50;">Meter Setup</a> section.</p>
    </div>
</div>

</body>
</html>
