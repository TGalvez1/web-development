function calculateBMI() {
    var name = document.forms["bmi_info"]["name"].value;
    var height = document.forms["bmi_info"]["height"].value;
    var weight = document.forms["bmi_info"]["weight"].value;
    var gender = document.forms["bmi_info"]["gender"].value;
    var category = "";
    var bmi = (weight * 703) / (height * height);

    document.getElementById("result").innerHTML = "Output Result: " + bmi;

    if (bmi > 40) {
        category = "very severely obese";
    }
    else if (bmi > 35 && bmi <= 40) {
        category = "severely obese";
    }
    else if (bmi > 30 && bmi <=35) {
        category = "moderately obese";
    }
    else if (bmi > 25 && bmi <= 30) {
        category = "overweight";
    }
    else if (bmi > 18.5 && bmi < 25) {
        category = "normal (healthy weight)";
    }
    else if (bmi > 16 && bmi <= 18.5) {
        category = "underweight";
    }
    else if (bmi >= 15 && bmi <= 16) {
        category = "severely underweight";
    }
    else if (bmi < 15) {
        category = "very severely underweight";
    }
    else {
        category = "dangerous (you should not be alive!)";
    }

    document.getElementById("desc").innerHTML = "Based on your results, your BMI is considered " + category + ". Thank you for your time, " + name + "!";
    return false;
}