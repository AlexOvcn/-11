import React from 'react'
import './ArtistInformation.css'


class ArtistInformation extends React.Component{
  render(){
    let {"album title": albumTitle, "artist name": artistName, "year of publication": publicationYear } = this.props.info
    return(
      <div className="mainSection-infoArtist">
        <h1 className="mainSection-infoArtist__albumTitle">{albumTitle}</h1>
        <p className="mainSection-infoArtist__yearOfPublication">{publicationYear}</p>
        <p className="mainSection-infoArtist__artistName">{artistName}</p>
      </div>
    )
  }
}

export default ArtistInformation;
