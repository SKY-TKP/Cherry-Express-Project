<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>

</head>

<body>
<th>Sender information </th> <br><br>
Name <br>
<input type="text" name="s_name" ><br><br>

Phone Number <br>
<input type="tel" name="s_tel"> <br><br>

Sent to <br>
<input type="text"> <br><br>

Postcode <br>
<input type="number" maxlength="5" minlength="5"><br><br>

<hr> <br>

<th>Reciever Information </th> <br><br>
Name <br>
<input type="text" name="r_name"><br><br>

Phone number <br>
<input type="tel" name="r_tel"> <br><br>

<hr><br>

<th>Type of parcel </th>

<select name="type">
    <option value="standard"> Standard </option>
    <option value="registered" selected> Registered </option>
    <option value="express" selected> Express </option>

</select>

<br><br>
<input type="submit" value="submit"></input>

</body>    

</html>