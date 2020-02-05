
document.addEventListener("DOMContentLoaded", function () {
  $(document).ready(function() {
    $.ajax({
      url: 'http://localhost:8888/webb19-bank/public/api/readUsers.php',
      success: function(parr) {
        console.log("SUCCESS get");
        var userObj;
        let userObjArray = [];
        
        //denna funktionen som jag återanvändre loopar igenom alla users och printar ut dom var beroende på vad jag slänger in i paramatern
        function printAllUsers(output) {
          for (let i = 0; i < parr.data.length; i++) {
            userObj = parr.data[i];
            userObjArray[userObj.account_id] = userObj;
            $(output).append(`<option value=${userObj.account_id}>${userObj.firstName}</option>`);
          }
        } printAllUsers("#personInput");

        //denna printar ut alla accounts som finns ifrån users och stoppar in det i to_account-inputen
        for (let i = 0; i < parr.data.length; i++) {
          accountObj = parr.data[i];
          $("#to_account").append(`<option>${accountObj.account_id}</option>`);
        }
        
        $("#personBtn").click(function() {
          let person = document.querySelector('#personInput').value;
          let userObj = userObjArray[person];
          $("#balanceOutput").empty();
          $("#balanceOutput").append(`<p>${userObj.balance}</p>`);
          $("#from_account").val(userObj.account_id);
        });
      } 
    });
  });

  //för att skapa en ny transaction och köra in i transactions-tabellen i db
  $("#transferBtn").click(function(e) {
    console.log("transferBtn klickades");
    e.preventDefault();
    let data = {"from_amount": $('#amountInput').val(), "from_account": $('#from_account').val(),"to_amount": $('#amountInput').val(), "to_account": $('#to_account').val()};
    $.ajax({
      type: 'POST',
      dataType: "json",
      url: 'http://localhost:8888/webb19-bank/public/api/createTransactions.php',
      data: JSON.stringify(data),
      success: function(parr) {
        console.log("post SUCCESS");
        console.log(parr);
      },
      error: function(parr) {
        console.error(parr);
      } 
    });
  });

});
