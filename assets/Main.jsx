import React from "react";
import ReactDOM from "react-dom"
import "./src/assets/style.scss"


const Main= ()=>{
  return(
      <div>
<h1>Message de teste</h1>

      </div>
  )
}

export default Main;
if (document.getElementById('root')) {
    ReactDOM.render(<Main />, document.getElementById('root'));
}