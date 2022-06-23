<!DOCTYPE html>
<html>
<head>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
</head>
<body>
    <form id="formid" action="database.php" method="POST">
        <label>Full Name: </label>
        <input type="text" id="name" name="name" required value="" pattern="^[a-zA-Z,. ]*$" title="Letters, periods and commas only"><br>
        <label>Email Address: </label>
        <input type="email" id="email" name="email" required value="" ><br> 
        <label>Mobile Number: </label>
        <input type="text" id="number" name="number" required value=""  pattern="^(09)\d{9}$" title="Numbers start with 09 and are 11 digits long"><br> 
        <label>Date of Birth: </label>
        <input type="date" id="birthdate" name="birthdate"  onchange="getAge()" required value=""><br> 
        <label>Age: </label>
        <input type="text" id="age" name="age" value="" readonly><br>
        <label>Gender: </label>
        <select name="gender" id="gender" name="gender" required value="" > 
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>

        <button type="submit" name="button" onclick = "insert()">Submit</button>
    </form>
    <script type="text/javascript">

        var form = document.getElementById("formid");
        function handleForm(event) { event.preventDefault(); }
        form.addEventListener('submit', handleForm);

        function insert(){
          $(document).ready(function(){
            $.ajax({
              url: 'database.php',
              type: 'POST',
              data: {
                name: $('#name').val(),
                email: $('#email').val(),
                number: $('#number').val(),
                birthdate: $('#birthdate').val(),
                age: $('#age').val(),
                gender: $('#gender').val(),
                action: "insert"
              },
              success:function(response){
                if(response == 1){
                  alert("Data Added Successfully!");
                }
                else{
                    alert(response);
                }
              }
            });
          });
        }

        function getAge() {
            var date = new Date($("#birthdate").val());
            var today = new Date();

            var timeDiff = Math.abs(today.getTime() - date.getTime());
            var age = Math.ceil(timeDiff / (1000 * 3600 * 24)) / 365;
            age = Math.floor(age);
            $("#age").val(age);
        }
      </script>
</body>
</html>