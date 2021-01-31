

// OPEN MINI CART 
    


window.addEventListener("load", function() {
        document.querySelector('.header-shop__icon-cart').addEventListener('mouseover', () => {
            document.querySelector('#cartcontents').style.display = 'flex'
})
        document.querySelector('.header-shop__icon-cart').addEventListener('mouseout', () => {
           document.querySelector('#cartcontents').style.display = 'none'
})
        document.querySelector('#cartcontents').addEventListener('mouseover', () => {
            document.querySelector('#cartcontents').style.display = 'flex'
})
        document.querySelector('#cartcontents').addEventListener('mouseout', () => {
            document.querySelector('#cartcontents').style.display = 'none'
})

      });
