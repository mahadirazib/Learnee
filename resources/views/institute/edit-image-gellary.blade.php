<x-app-layout>

  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
    var emails = [];
    var phone_numbers = [];
    var passkeys = [];
  </script>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">


          <div>
            Edit Image gallery
          </div>


        </div>
      </div>
    </div>
  </div>





  <script>

      $('input').on('keypress', function(e) {
          if (e.which == 13) {
              e.preventDefault();
          }
      });


      // Handle emails ----------------------------------------------------------->>>>>>>>>
      $(document).ready(function() {
          // Function to add an email
          function addEmail(singleEmail) {
              var emailHtml =
                  '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' +
                  singleEmail + ' <input type="hidden" name="emails[]" value="' + singleEmail + '">  </div>';
              $('#emailContainer').append(emailHtml);
          }

          // Function to remove an email
          $(document).on('click', '#emailContainer div', function() {
              let removableEmail = $(this).text();
              let index = emails.indexOf(removableEmail);
              $('#emailInput').val(removableEmail);
              emails.splice(index, 1);
              $(this).remove();
          });

          function validateEmail(email) {
              var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
              return regex.test(email);
          }

          // Listen for keypress event on input field
          $('#emailInput').keypress(function(event) {
              if (event.which === 13) { // Check if Enter key is pressed
                  var singleEmail = $(this).val().trim();
                  if (singleEmail !== '') {

                      if (validateEmail(singleEmail)) {
                          if (!emails.includes(singleEmail)) {
                              addEmail(singleEmail);
                              emails.push(singleEmail)
                              $(this).val(''); // Clear input field after adding email
                          } else {
                              $('#emailInput').val('This Email already added');
                          }
                      } else {
                          $('#emailInput').val('Please Enter a valid email');
                      }

                  }
              }
          });
      });




      // Handle Mobile Numbers ----------------------------------------------------------->>>>>>>>>
      $(document).ready(function() {
          // Function to add
          function addPhone(singlePhone) {
              var phoneHtml =
                  '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' + singlePhone + ' <input type="hidden" name="mobile_numbers[]" value="'  + singlePhone + '"> </div>';
              $('#phoneContainer').append(phoneHtml);
          }

          // Function to remove
          $(document).on('click', '#phoneContainer div', function() {
              let removablePhone = $.trim($(this).text());
              let index = phone_numbers.indexOf(removablePhone);
              $('#phoneInput').val(removablePhone);
              phone_numbers.splice(index, 1);
              $(this).remove();
          });

          function validateNumber(inputString) {
              var regex = /^\+?[0-9]+$/;
              return regex.test(inputString);
          }

          // Listen for keypress event on input field
          $('#phoneInput').keypress(function(event) {
              if (event.which === 13) { // Check if Enter key is pressed
                  var singlePhone = $(this).val().trim();
                  if (singlePhone !== '') {
                      if (validateNumber(singlePhone)) {
                          if (!phone_numbers.includes(singlePhone)) {
                              addPhone(singlePhone);
                              phone_numbers.push(singlePhone);
                              $(this).val(''); // Clear input field after adding phone number
                          } else {
                              $('#phoneInput').val('This Number already added');
                          }
                      } else {
                          $('#phoneInput').val('Please Enter a valid phone number');
                      }

                  }
              }
          });
      });




      // Handle Passkeys ----------------------------------------------------------->>>>>>>>>
      $(document).ready(function() {
          // Function to add
          function addPasskey(singlePasskey) {
              var passkeyHtml =
                  '<div class="bg-gray-200 text-black px-3 py-1 rounded cursor-pointer hover:bg-gray-700 hover:text-white">' +
                  singlePasskey + '<input type="hidden" name="passkeys[]" value="' + singlePasskey + '"></div>';
              $('#passkeyContainer').append(passkeyHtml);
          }

          // Function to remove
          $(document).on('click', '#passkeyContainer div', function() {
              let removablePasskey = $.trim($(this).text());
              let index = passkeys.indexOf(removablePasskey);
              $('#passkeyInput').val(removablePasskey);
              passkeys.splice(index, 1);
              $(this).remove();
          });

          // Listen for keypress event on input field
          $('#passkeyInput').keypress(function(event) {
              if (event.which === 13) { // Check if Enter key is pressed
                  var singlePasskey = $(this).val().trim();
                  if (singlePasskey !== '') {
                      if (!passkeys.includes(singlePasskey)) {
                          addPasskey(singlePasskey);
                          passkeys.push(singlePasskey);
                          $(this).val(''); // Clear input field after adding phone number
                      } else {
                          $('#passkeyInput').val('This passkey already added');
                      }

                  }
              }
          });
      });





      // Handle Form Submission ----------------------------------------------------------->>>>>>>>>

      // $(document).ready(function() {
      //     $("#submitButton").click(function(event) {
      //         event.preventDefault(); // Prevent default form submission

      //         var formData = new FormData($("#myForm")[0]);

      //         admins.forEach(el => {
      //             formData.append("admins[]", el);
      //         });

      //         emails.forEach(el => {
      //             formData.append("emails[]", el);
      //         });

      //         phone_numbers.forEach(el => {
      //             formData.append("mobile_numbers[]", el);
      //         });

      //         passkeys.forEach(el => {
      //             formData.append("passkeys[]", el);
      //         });


      //         // Display the key/value pairs
      //         // for (var pair of formData.entries()) {
      //         //     console.log(pair[0]+ ', ' + pair[1]);
      //         // }

      //         $.ajax({
      //             url: "{{ route('institute.create') }}",
      //             type: "post",
      //             data: formData,
      //             processData: false, // Prevent jQuery from processing data
      //             contentType: false, // Prevent jQuery from setting content type
      //             success: function(response) {
      //                 // Handle successful form submission response
      //                 console.log("Form submitted successfully!");
      //                 console.log(response.data.id);
      //                 let id = response.data.id;
      //                 window.location.replace(window.location.origin + "/institute/" + id)
      //             },
      //             error: function(xhr, status, error) {
      //                 console.error("Error submitting form:", error);
      //                 // Handle form submission error
      //             }
      //         });
      //     });
      // });



      function getCookie(name) {
          var value = "; " + document.cookie;
          var parts = value.split("; " + name + "=");
          if (parts.length === 2) return parts.pop().split(";").shift();
      }
  </script>




</x-app-layout>
