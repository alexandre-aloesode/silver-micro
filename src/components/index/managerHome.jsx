import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import { useContext, useEffect, useState } from "react";
import Bookings from "../manager/bookings";
import Restaurants from "../manager/restaurants";

export default function ManagerHome() {
  const [view, setView] = useState(1);
  return (
    <div
      style={{
        display: "flex",
        flexDirection: "column",
        // justifyContent: "space-between",
        width: "100%",
        height: "100%",
      }}
    >
      <div
      style={{
        display: "flex",
        justifyContent: "space-between",
        width: "100%",
      }}
    >
        <Button
          variant="contained"
          onClick={() => {
            setView(1);
          }}
        >
          Réservations
        </Button>
        <Button
          variant="contained"
          onClick={() => {
            setView(2);
          }}
        >
          Mes restaurants
        </Button>
      </div>
      {view == 1 && <Bookings />}
      {view == 2 && <Restaurants />}
    </div>
  );
}
