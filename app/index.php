<?php
include_once __DIR__ . "/services/CProducts.php";

$CProducts = new CProducts();
$products = $CProducts->getProducts();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akramooo Test</title>
</head>
<body>
    <div class="main-container">
        <table class="prod_table">
            <tr>
                <th>ID</th>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Article</th>
                <th>Quantity</th>
                <th>Date create</th>
                <th>Action</th>
            </tr>
            <?php foreach ($products as $product):?>
        <?php if (!$product['IS_HIDDEN']):?>        
            <tr class="prod_col">
                <td class="prod_id"><?=$product['ID']?></td>
                <td><?=$product['PRODUCT_ID']?></td>
                <td><?=$product['PRODUCT_NAME']?></td>
                <td><?=$product['PRODUCT_PRICE']?></td>
                <td><?=$product['PRODUCT_ARTICLE']?></td>
                <td>
                    <button class="minus-btn">-</button> <span class="quantity" ><?=$product['PRODUCT_QUANTITY']?></span> <button class="plus-btn">+</button>
                </td>
                <td><?=$product['DATE_CREATE']?></td>
                <td><button class="hide_btn">скрыть</button></td>
            </tr>
        <?php endif;?>
            <?php endforeach;?>
        </table>
    </div>

</body>
</html>

<script>    
    // HIDE FUNCTION
    const hideBtns = document.querySelectorAll('.hide_btn');
    const prodColumn = document.querySelector('.prod_col')

    hideBtns.forEach(hideBtn => {
        hideBtn.addEventListener("click", (event) => {
            const row = event.target.closest('tr')
            const prodID = row.querySelector('.prod_id').textContent
            fetch(`services/CProducts.php?id=${encodeURIComponent(prodID)}`, {
                method: 'GET',
            }).then(res => {
                if (!res.ok){
                    throw new Error('Ошибка: ' + res.statusText);
                }
                return res.json();
            }).then(data => {
                console.log('Success: ', data);
                row.remove();
            }).catch(error => {
                console.log("Error: ", error);
            })
        })
    })


    // INCREASE OR DECREASE FUNCTION

    const PlusBtns = document.querySelectorAll('.plus-btn')
    const MinusBtns = document.querySelectorAll('.minus-btn')

    PlusBtns.forEach(PlusBtn => {
        PlusBtn.addEventListener("click", (event) => {
            const row = event.target.closest('tr')
            const prodID = row.querySelector('.prod_id').textContent
            let quantityElement = row.querySelector('.quantity')
            let rowQuantity = parseInt(quantityElement.textContent, 10)
            rowQuantity++;
            quantityElement.textContent = rowQuantity;
            
            
            fetch(`services/CProducts.php?id=${encodeURIComponent(prodID)}&type=plus`, {
                method: 'GET',
            }).then(response => {
                if (!response.ok){
                    throw new Error('Ошибка: ' , response.statusText)
                }
                return response.json();
            }).then(data => {
                console.log('Success', data);
            }).catch(error => {
                console.log('Error: ', error);
                
            })
            
        })
    })





    MinusBtns.forEach(MinusBtn => {
        MinusBtn.addEventListener("click", (event) => {
            const row = event.target.closest('tr')
            const prodID = row.querySelector('.prod_id').textContent
            let quantityElement = row.querySelector('.quantity')
            let rowQuantity = parseInt(quantityElement.textContent, 10)
            rowQuantity--;
            quantityElement.textContent = rowQuantity;

            fetch(`services/CProducts.php?id=${encodeURIComponent(prodID)}&type=minus`, {
                method: 'GET',
            }).then(response => {
                if (!response.ok){
                    throw new Error('Ошибка: ' , response.statusText)
                }
                return response.json();
            }).then(data => {
                console.log('Success', data);
            }).catch(error => {
                console.log('Error: ', error);
                
            })
            
        })
    })

</script>

<style>

    *{
        padding: 0;
        margin: 0;
    }

    .main-container{
        display: flex;
        justify-content: center;
    }

    .prod_table{
        width: 80%;
        text-align: center;
        border: 1px solid black;
        margin-top: 3em;
    }

    tr{
        font-size: 22px;
    }

    td{
        padding: 8px;
        padding-inline: 12px;
    }

    .quantity{
        padding-inline: 5px;
    }

    .plus-btn, .minus-btn{
        width: 2em;
        height: 2em;
        border-radius: 20px;
        border: 1px solid black;
        cursor: pointer;
    }

    .plus-btn:hover{
        background-color:lightgreen;
        color: white;   
    }

    .minus-btn:hover{
        background-color:red;
        color: white;   
    }

    .hide_btn{
        cursor:pointer;
        padding: 6px;
        font-size: 14px;
        border-radius: 2em;
        border: 1px solid black;
    }

    .hide_btn:hover{
        background-color: yellow;
    }
</style>