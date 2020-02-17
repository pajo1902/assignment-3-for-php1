document.addEventListener("DOMContentLoaded", function () {

  //Gör ett GET-anrop för att hämta hem alla användare som finns på databasen
  $(document).ready(function () {
    $.ajax({
      url: 'http://localhost:8888/assignment-3-for-php1/public/api/readUsers.php',
      success: function (parr) {
        console.log("SUCCESS get");

        var userObj;
        var userObjArray = [];

        //loopar igenom alla användare och printar ut deras firstname i select-elementet
          for (let i = 0; i < parr.data.length; i++) {
            userObj = parr.data[i];
            userObjArray[userObj.account_id] = userObj;
            $('#personInput').append(`<option value=${userObj.account_id}>${userObj.firstName}</option>`);
          }

        //loopar igenom alla användare konton och printar ut deras account_id:s
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

  //POST:ar data för att genomföra en transaktion
  $("#transferBtn").click(function(e) {
    e.preventDefault();
    let data = {"from_amount": $('#amountInput').val(), "from_account": $('#from_account').val(),"to_amount": $('#amountInput').val(), "to_account": $('#to_account').val()};
    
    $.ajax({
      type: 'POST',
      dataType: "json",
      url: 'http://localhost:8888/assignment-3-for-php1/public/api/createTransactions.php',
      data: JSON.stringify(data),
      success: function(parr) {
      },
      error: function(a, b, c) 
      {
        if (!a.responseText.includes("för lite")) {
          $("#transMessage").empty();
          $("#transMessage").append("Transaktionen gick fint!");
        } else {
          $("#transMessage").empty();
          $("#transMessage").append("Transaktionen kunde inte genomföras då det inte fanns tillräckligt med pengar på ditt konto!");
        }
      }  
    });

    //Gör en ny GET för att uppdatera balansen efter en transaktion
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
