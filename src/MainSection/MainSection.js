import './MainSection.css'
import AttractionsCards from '../AttractionsCards/AttractionsCards'

const cards = [
    {id: 0, photoUrl: {backgroundImage: 'url("https://img.lookmytrips.com/images/look7ubi/big-5843cb37ff936771f60478f0-58df492d320ac-1cdui9d.jpg")'}, angle: {transform: 'rotate(-23deg)'}, description: 'Пермяк солёные уши'},
    {id: 1, photoUrl: {backgroundImage: 'url("https://rosphoto.com/images/u/ugallery/1408/_mg_0492_kopiya.jpg")'}, angle: {transform: 'rotate(0deg)'}, description: 'Райский сад'},
    {id: 2, photoUrl: {backgroundImage: 'url("https://static.orpheusradio.ru/images/753/5/e03ed58a.jpg")'}, angle: {transform: 'rotate(16deg)'}, description: 'Пермский театр оперы и балета'}
]

export default function MainSection() {
    return (
        <section className="mainSection clearfix">
            <p className="mainSection-description">Город располагающийся на востоке европейской части России, в Предуралье, на берегах Камы. Город основан в 1723 году, в 1940-1957 годах имел название Молотов. Население города чуть более миллиона человек.</p>
            <p className="mainSection-annotation">Если говорить вкратце- город как город, ничем особо не выделяющийся.
            </p>
            <AttractionsCards cards={cards}/>
            <p className="mainSection-descriptionForAttractions">Что касается достопримечательностей, их не много, да и примечательны ли они.
            Город неплохой, но не для экскурсий.</p>
            <p className="mainSection-nature">Так что вот пару фотографий нашей природы!</p>
        </section>
    )
}