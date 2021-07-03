import {useState} from 'react';

function Counter(){
    let [cnt, setCnt] = useState(0);

    function increment(){
        setCnt(cnt + 1)
    }
    function derement(){
        setCnt(cnt - 1)
    }  

    return (
        <div>
            <button onClick={derement}> - </button>
            <span> {cnt} </span>
            <button onClick={increment}> + </button>
        </div>
    )
}

export default Counter;