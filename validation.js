function validateEmail() {
    const emailField = document.querySelector('input[name="email"]');
    const email = emailField.value;

    const studentRegex = /^[0-9]{9}@stu\.uob\.edu\.bh$/; // 9 digits followed by @stu.uob.edu.bh
    const doctorRegex = /^[a-zA-Z]+@uob\.edu\.bh$/; // Only letters followed by @uob.edu.bh

    if (!studentRegex.test(email) && !doctorRegex.test(email)) {
        alert("Invalid email format. For students: 9 digits + '@stu.uob.edu.bh'. For doctors: letters + '@uob.edu.bh'.");
        return false; // Prevent form submission
    }
    return true;
}
