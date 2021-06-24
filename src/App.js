import React, {Component} from 'react'
import ArtistInformation from './ArtistInformation/ArtistInformation'
import CoverArt from './CoverArt/CoverArt'
import Runner from './Runner/Runner'

class App extends Component{
  constructor(props) {
    super(props)
    this.state = {
      "album title": 'Мой любимый альбом',
      "artist name": 'Мой фаворит',
      "year of publication": 'SOON',
      "Album Cover art": {
        // backgroundImage: 'url("Ваша обложка")'
      },
      "mouse tracking": 0
    }
  }
  updateState = (value) => {
    return this.setState((prevState, prevProps) => {
      return {"mouse tracking": value} 
    })
  }
  render(){
    console.log(this.state)
    return(
      <div className='container'>
        <ArtistInformation info={this.state}/>
        <CoverArt art={this.state}/>
        <Runner trackingX={this.updateState}/>
      </div>
    )
  }
}

export default App;
