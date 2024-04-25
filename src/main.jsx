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
          width: "100vw",
          gap: "10px",
        }}
      >
        <NavBar />
        <AppRouterProvider />
      </div>
    </UserContextProvider>
  </React.StrictMode>
);
