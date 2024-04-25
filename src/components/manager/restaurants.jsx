import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import { useContext, useEffect, useState } from "react";
import CreateRestaurant from "./createRestaurant";
import { dbGet } from "../../api/database";

export default function restaurants() {
  const [addNewRestaurant, setAddNewRestaurant] = useState(false);
  const [restaurants, setRestaurants] = useState([]);

  useEffect(() => {
    dbGet({
      route: "restaurant",
      params: {
        restaurant_id: "",
        restaurant_name: "",
      },
    })
    .then((data) => {
      setRestaurants(data);
    });
  }, []);

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
