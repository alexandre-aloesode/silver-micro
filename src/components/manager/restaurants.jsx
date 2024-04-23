import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import { useContext, useEffect, useState } from "react";
import CreateRestaurant from "./createRestaurant";

export default function restaurants() {
  const [addNewRestaurant, setAddNewRestaurant] = useState(false);

  return (
    <div>
      {addNewRestaurant == true ? (
        <CreateRestaurant openModal={setAddNewRestaurant} />
      ) : (
        <div>
          <Button
            variant="contained"
            onClick={() => {
              setAddNewRestaurant(true);
            }}
          >
            Ajouter un restaurant
          </Button>
          <h1>Restaurants</h1>
        </div>
      )}
    </div>
  );
}
