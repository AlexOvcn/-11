//* Homework-26

class Card { 
    constructor(params) {
        this.gridItem = document.querySelector(`#${params.id}`);
        this.mainWindow = this.gridItem.querySelector('.grid-container__item_mainWindow');
        this.changes = this.mainWindow.hasChildNodes();
        this.cross = this.gridItem.querySelector('.grid-container__item_windowAddingInfo--cross');
        this.gridItem.addEventListener('dblclick', () => this.showAdd())
        this.recordingLastTap;
        this.gridItem.addEventListener('touchstart', () => { // Это аналог двойного клика мышью(dblclick) для тачскринов
            let now = new Date().getTime();
            let timeDifference = now - this.recordingLastTap;
            if((timeDifference < 300) && (timeDifference > 0)){
                this.showAdd()
            }
            this.recordingLastTap = new Date().getTime();
        })
        this.cross.addEventListener('click', () => this.hiddenAdd())
        this.form = this.gridItem.querySelector('.formInWindowAddingInfo');
        this.inputURL_Picture = this.form.URL_input;
        this.inputOfDescription = this.form.description_input;
        this.buttonForAddChanges = this.form.buttonForAddChanges;
        this.inputURL_Picture.addEventListener('change', () => this.accessAddButton())
        this.inputOfDescription.addEventListener('keyup', () => this.accessAddButton())
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.addChanges();
            this.hiddenAdd();
        })
        this.addScreenSaver = this.gridItem.querySelector('.grid-container__item_addScreenSaver');
        this.windowAddingInfo = this.gridItem.querySelector('.grid-container__item_windowAddingInfo')
    }
    showAdd() {
        if(this.changes !== true) {
            if (!this.addScreenSaver.classList.contains('hidden')) {
                this.addScreenSaver.classList.add('hidden')
            }
            if (this.windowAddingInfo.classList.contains('hidden')) {
                this.windowAddingInfo.classList.remove('hidden')
            }
        }
    }
    hiddenAdd() {
        this.inputURL_Picture.value = '';
        this.inputOfDescription.value = '';
        this.accessAddButton()
        this.changes = this.mainWindow.hasChildNodes();
        if(this.changes !== true) {
            if (this.addScreenSaver.classList.contains('hidden')) {
                this.addScreenSaver.classList.remove('hidden')
            }
            if (!this.windowAddingInfo.classList.contains('hidden')) {
                this.windowAddingInfo.classList.add('hidden')
            }
        }
    }
    addChanges() {
        this.mainWindow.innerHTML = `<img class="grid-container__item_mainWindow--img" src="${this.inputURL_Picture.value}" alt="">
        <h1 class="grid-container__item_mainWindow--description">${this.inputOfDescription.value}</h1>`
        this.changes = this.mainWindow.hasChildNodes();
        if (!this.windowAddingInfo.classList.contains('hidden')) {
            this.windowAddingInfo.classList.add('hidden')
        }
    }
    accessAddButton() {
        let pattern = /http.+[./]+/g
        if (this.inputOfDescription.value !== '' && pattern.test(this.inputURL_Picture.value) === true) {
            this.buttonForAddChanges.disabled = false;
        } else {
            this.buttonForAddChanges.disabled = true;
        };
    }
}

let changesCards = document.querySelector('.changeCards');
let allPencil =  document.querySelectorAll('.grid-container__item_clickForChanges');
let textInchangesCards = document.querySelector('.changeCards_text');
let clickOnChangesCards = 0;

function changesCardsFunction() {
    allPencil.forEach(pencil => {
        let gridItem = pencil.closest(".grid-container__item");
        let grayScreen = gridItem.querySelector('.grid-container__item_grayScreen')
        let mainWindow = gridItem.querySelector('.grid-container__item_mainWindow');
        let changes = mainWindow.hasChildNodes();
        if(changes === true && clickOnChangesCards === 0) {
            if (pencil.classList.contains('hidden')) {
                pencil.classList.remove('hidden')
            }
            if (!grayScreen.classList.contains('greyScreen')) {
                grayScreen.classList.add('greyScreen')
            }
        }
        if(changes === true && clickOnChangesCards === 1) {
            if (!pencil.classList.contains('hidden')) {
                pencil.classList.add('hidden')
            }
            if (grayScreen.classList.contains('greyScreen')) {
                grayScreen.classList.remove('greyScreen')
            }
        }
    });
    if (clickOnChangesCards === 0) {
        if (textInchangesCards.classList.contains('colorShadowTextGreen')) {
            textInchangesCards.classList.remove('colorShadowTextGreen')
            textInchangesCards.classList.add('colorShadowTextRed')
            setTimeout(() => {
                textInchangesCards.innerHTML = 'Закончить изменения!'
            }, 100);
        }
        clickOnChangesCards += 1;
    } else if (clickOnChangesCards === 1) {
        if (textInchangesCards.classList.contains('colorShadowTextRed')) {
            textInchangesCards.classList.add('colorShadowTextGreen')
            textInchangesCards.classList.remove('colorShadowTextRed')
            setTimeout(() => {
                textInchangesCards.innerHTML = 'Изменить карточку?'
            }, 100);
        }
        clickOnChangesCards -= 1;
    }
}

changesCards.addEventListener('click', () => changesCardsFunction())

function ChangesCardsPencil(pen) {
    this.gridItem = pen.closest(".grid-container__item");
    this.mainWindow = this.gridItem.querySelector('.grid-container__item_mainWindow');
    this.windowAddingInfo = this.gridItem.querySelector('.grid-container__item_windowAddingInfo');
    this.grayScreen = this.gridItem.querySelector('.grid-container__item_grayScreen');
    pen.addEventListener('click', () => {
        this.mainWindow.innerHTML = '';
        changesCardsFunction()
        if (this.grayScreen.classList.contains('greyScreen')) {
            this.grayScreen.classList.remove('greyScreen')
        }
        if (this.windowAddingInfo.classList.contains('hidden')) {
            this.windowAddingInfo.classList.remove('hidden')
        }
        if (!pen.classList.contains('hidden')) {
            pen.classList.add('hidden')
        }
    })
}
allPencil.forEach(pencil => {
    pencil = new ChangesCardsPencil(pencil)
});


let item1 = new Card({
    id: 'itemGrid1',
})
let item2 = new Card({
    id: 'itemGrid2',
})
let item3 = new Card({
    id: 'itemGrid3',
})
let item4 = new Card({
    id: 'itemGrid4',
})
let item5 = new Card({
    id: 'itemGrid5',
})
let item6 = new Card({
    id: 'itemGrid6',
})
let item7 = new Card({
    id: 'itemGrid7',
})
let item8 = new Card({
    id: 'itemGrid8',
})
let item9 = new Card({
    id: 'itemGrid9',
})
let item10 = new Card({
    id: 'itemGrid10',
})
let item11 = new Card({
    id: 'itemGrid11',
})
let item12 = new Card({
    id: 'itemGrid12',
})