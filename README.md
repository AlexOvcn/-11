##Дипломная работа (!)

Сводка: 1) SVG элементы (находящиеся в sprite.svg) не отображаются при открытии без порта, при открытии плагином Live Server отображаются 2 первые иконки из спрайта, при открытии работы посредством сервера GULP (плагин browser-sync) отображаются svg элементы в полном составе. (Способ генерации спрайта "stack")

	2) Проблема кроется в функции по изменению поля покупок (числовое значение), а именно у третьего слайдера при срабатывании breakpoint: 700 (от 700px и ниже) эта функция перестает работать, и только при удалении параметра "responsive" все начинает функционировать. (Сама функция, как и слайдер используют jquery)
	   Функция срабатывает при нажатии кнопки "купить" у товаров третьего слайдера.

	UPD: v1.0.1
	
	1) Исправил отображение SVG элементов (при открытии с помощью Live Server в VScode) путем замены метода генерации svgSprite stack>symbol.