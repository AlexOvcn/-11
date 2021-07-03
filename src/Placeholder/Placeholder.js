import {useState} from 'react';
import './Placeholder.css';

function Placeholder() {
  let [placeholders, setPlaceholders] = useState({
    1: 'https://via.placeholder.com/150.png/FDF5E6/20B2AA',
    2: 'https://via.placeholder.com/300x150.png/DDA0DD/e01515?text=placeholder.com',
    3: 'https://via.placeholder.com/80x150.png/7FFF00/7FFF00',
    4: 'https://via.placeholder.com/80x150.png/FFFF00/FFFF00',
    5: 'https://via.placeholder.com/80x150.png/FFA500/FFA500',
    6: 'https://via.placeholder.com/80x150.png/FF4500/FF4500',
    "my placeholder": '',
  });
  return (
    <>
    <div className="placeholders">
      {
        Object.keys(placeholders).map((PH, index) => {
          if(PH === "my placeholder") {
            return <p key={index}></p>
          }
          let img = placeholders[PH]
          return (
            <img src={img} alt="placeholder" key={index} className="placeholders-item"/>
          )
        })
      }
    </div>
    <div className='myPlaceholder'>
      <input
      type="text"
      onChange={(e) => {
        let newObj = {};
        Object.keys(placeholders).map((item) => {
          if (item === "my placeholder") {
            newObj[item] =  e.target.value
            return placeholders[item] = newObj[item]
          }
          return newObj[item] = placeholders[item]
        })
        setPlaceholders(newObj)
      }}
      className='myPlaceholder-input'
      placeholder="Вставьте свой адрес картинки"
      />
      {placeholders["my placeholder"].length ? <img src={placeholders["my placeholder"]} alt="Проверьте правильность написания адреса" className="myPlaceholder-img"/> : <p className="myPlaceholder-text">Здесь будет ваша картинка</p>}
    </div>
    </>
  );
}

export default Placeholder;
