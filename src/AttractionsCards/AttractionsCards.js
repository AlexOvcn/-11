import './AttractionsCards.css'

export default function AttractionsCards({cards}) {
    return (
        <div className='cards'>
            {cards.map((card) => {
                return (
                    <div className='cards-card' key={card.id} style={card.angle}>
                        <div className="cards-card__picture" style={card.photoUrl}></div>
                        <p className="cards-card__title">{card.description}</p>
                    </div>
                )
            })}
        </div>
    )
}