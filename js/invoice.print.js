$(document).ready(function () {

  // cek cap etme funksiyasi texniki sebeblerden dayandirilib
  // $(document).on('click', '.send-cart', function (e) {


  //   let confirmation = confirm("Çek çap edilsin mi?");
  //   if (!confirmation) {
  //       
  //       return false;
  //     }
  //     else{
  //       ClickToPrintOp();
  //     }

    


  // });

  function ClickToPrintOp() {
    // copy table from html
    let table = $(".cart-item-list").html();

    // take total amount
    let amount = $(".cart-res").html();

    // take sellers name
    let sellerName = $(".ls-dropdown-text").html();

    // open a new window
    let printedData = window.open("");

    // new html variable
    let newPageItems;

    let printdate = new Date().toLocaleDateString("en-GB");
    let printtime = new Date().toLocaleTimeString("en-GB", {
      hour12: false,
      hour: "numeric",
      minute: "numeric",
    });

    newPageItems = `
            <head>
            <!DOCTYPE html>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
          name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <title> ${printdate} ${printtime} faktura</title>

        
    
        <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }
    
    th, td {
        text-align: left;
        padding: 15px;
      }
    
    
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    

    .cart-counter{
        display:none!important;
    }
    .add-basket-btn-icon{
        display:none!important;
    }
    .cart-input-price-icon{
        display:none!important;
    }
    .remove-at-cart{
        display:none!important;
    }

    </style>
      </head>
      <body>
        <div>
        <h3 style="text-align: center">Satış Fakturası</h3>
        <p > Tarix və saat: <span style="font-weight: bold;"> ${printdate}  ${printtime}</span></p>
        
        <p > Satıcı: <span style="font-weight: bold;"> ${sellerName}</span></p>
        </div>
        <div class="container-fluid">
                  <table  >
                  <tbody >
                    ${$(table).html()}
                    </tbody >
                  </table>

                  <div>${amount}</div>
    
                </div>
                <br>
    
                <div>
                
    
    
    
                </div>

        </body>
        
           `;

    $(newPageItems).append();

    //   printedData.append($("#resultLoanTable"))

    printedData.document.write(newPageItems);
    const delay = setTimeout(printDelay, 1000);
    function printDelay() {
      printedData.print();
    }
  }
});
