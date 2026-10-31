const prevButton = document.getElementById('prev')
const nextButton = document.getElementById('next')

const items = document.querySelectorAll(".item")
const dots = document.querySelectorAll(".dot")

const numberIndicator = document.querySelector('.numbers')
const list = document.querySelector('.list')


// let é utilizado pq o número não e constante, o numero altera //
let active = 0;
let timer;
const total = items.length


function update(direction) {
    document.querySelector('.item.active').classList.remove('active')
    document.querySelector('.dot.active').classList.remove('active')

    if (direction > 0) {
        active = active + 1

        if (active === total) {
            active = 0
        }
    } 
    else if (direction < 0){
        active = active -1

        if (active < 0) {
            active = total -1
        }
    }

    items[active].classList.add('active')
    dots[active].classList.add('active')

    // adiciona o "0" atras do número //
    numberIndicator.textContent = String (active + 1).padStart (2,'0')

}


    clearInterval (timer)
    timer = setInterval(() => {
        update (1)
    }, 4000);

// evento de clique do botão para passar a img //
prevButton.addEventListener('click', () => {
    update(-1)
})
nextButton.addEventListener('click', () => {
        update(1)
})

