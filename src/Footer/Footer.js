import './Footer.css'

export default function Footer() {
    let photoNature = {
        1: {backgroundImage: 'url("https://static.tildacdn.com/tild3863-3962-4536-b935-633536616633/IMG_2639.jpg")'},
        2: {backgroundImage: 'url("https://cdn.photosight.ru/img/0/9ea/6073749_xlarge.jpg")'},
        3: {backgroundImage: 'url("https://s3.nat-geo.ru/images/2019/5/17/34c7db09ad764f12b670e19abe095692.max-2500x1500.jpg")'},
    }
    return (
        <div className="footer">
            {Object.keys(photoNature).map((photoInd) => {
                console.log(photoInd)
                return (
                    <div className="footer-photoNature" style={photoNature[photoInd]} key={photoInd}></div>
                )
            })}
            <p className="footer-end">Конец!</p>
        </div>
    )
}