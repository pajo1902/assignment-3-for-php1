
document.addEventListener("DOMContentLoaded", function () {

  $(document).ready(function () {

    $.ajax({
      url: 'http://localhost:8888/assignment-3-for-php1/public/api/readUsers.php',
      success: function (parr) {
        console.log("SUCCESS get");

        var userObj;
        var userObjArray = [];

        //loopar igenom alla users och printar ut deras firstname
          for (let i = 0; i < parr.data.length; i++) {
            userObj = parr.data[i];
            userObjArray[userObj.account_id] = userObj;
            $('#personInput').append(`<option value=${userObj.account_id}>${userObj.firstName}</option>`);
          }

        //loopar igenom alla users konton och printar ut deras account_id:s
        for (let i = 0; i < parr.data.length; i++) {
          accountObj = parr.data[i];
          $("#to_account").append(`<option>${accountObj.account_id}</option>`);
        }

        $("#personBtn").click(function () {
          $("#transMessage").empty();
          let person = document.querySelector('#personInput').value;
          userObj = userObjArray[person];
          $("#balanceOutput").empty();
          $("#balanceOutput").append(`<p>${userObj.balance} SEK</p>`);
          $("#from_account").val(userObj.account_id);
        });

      }
    });
  });

  //post a new transaction clicking on transferBtn
  $("#transferBtn").click(function(e) {
    e.preventDefault();
    let data = {"from_amount": $('#amountInput').val(), "from_account": $('#from_account').val(),"to_amount": $('#amountInput').val(), "to_account": $('#to_account').val()};
    
    $.ajax({
      type: 'POST',
      dataType: "json",
      url: 'http://localhost:8888/assignment-3-for-php1/public/api/createTransactions.php',
      data: JSON.stringify(data),
      success: function(parr) { //den går aldrig in här????
        //ssuccess kanske heter nåt annat?
        console.log("post SUCCESS");
        console.log(parr);
      },
      error: function(parr) {
        console.error(parr);
      }
    });

    //för att kolla på klienten så inte överföringen överstiger balance, isåfall skicka felmeddelande
    $.ajax({
      url: 'http://localhost:8888/assignment-3-for-php1/public/api/readUsers.php',
      success: function(parr) {
        var userObj;
        var userObjArray = [];
        
        //denna funktionen loopar igenom alla users
        for (let i = 0; i < parr.data.length; i++) {
          userObj = parr.data[i];
          userObjArray[userObj.account_id] = userObj;
        }

        let person = document.querySelector('#personInput').value;
        userObj = userObjArray[person];
        let balance = userObj.balance;
        let amount = $('#amountInput').val();

        if (balance < amount) {
          $("#transMessage").empty();
          $("#transMessage").append(`<p>"Medges ej!"</p>`);
        } else {
          $("#transMessage").empty();
          $("#transMessage").append(`<p>"Transaktionen genomfördes!"</p>`);
        }
      } 
    });

    //denna är enbart för att uppdatera balance-paragrafen när man har gjort en transaction
    $.ajax({
      url: 'http://localhost:8888/assignment-3-for-php1/public/api/readUsers.php',
      success: function(parr) {
        console.log("SUCCESS get balance");
        
        var userObj;
        var userObjArray = [];
        
        //denna funktionen loopar igenom alla users
        for (let i = 0; i < parr.data.length; i++) {
          userObj = parr.data[i];
          userObjArray[userObj.account_id] = userObj;
        }

        let person = document.querySelector('#personInput').value;
        userObj = userObjArray[person];
        $("#balanceOutput").empty();
        $("#balanceOutput").append(`<p>${userObj.balance} SEK</p>`);
      } 
    });
  });
});
