import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import NavBar from "./components/navBar";
import { UserContextProvider } from "./context/userContext";
import { AppRouterProvider } from "./context/router.jsx";

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <UserContextProvider>
      <div
        style={{
          display: "flex",  
          flexDirection: "column",
          justifyContent: "space-between",
          width: "100%",
          height: "100%",
          gap: "10px",
          margin: 0,
          // overflow: "hidden",
          // border: "1px solid red",
        }}
      >
        <AppRouterProvider />
        <NavBar />
      </div>
    </UserContextProvider>
  </React.StrictMode>
);
