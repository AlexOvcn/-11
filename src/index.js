import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import Header from './Header/Header'
import MainSection from './MainSection/MainSection'
import Footer from './Footer/Footer'

ReactDOM.render(
  <React.StrictMode>
    <div className="container">
      <Header />
      <MainSection />
    </div>
    <Footer />
  </React.StrictMode>,
  document.getElementById('root')
);


