import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import MenuItem from "@mui/material/MenuItem";
import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import InputLabel from "@mui/material/InputLabel";
import ListItemText from "@mui/material/ListItemText";
import Checkbox from "@mui/material/Checkbox";
import OutlinedInput from "@mui/material/OutlinedInput";
import { useEffect, useState } from "react";
import { dbGet, dbPut } from "../../api/database";
import axios from "axios";
import "../../../src/App.css";

export default function ManageImages(params) {
  const [images, setImages] = useState([]);
  const [upload, setUpload] = useState([]);

  function loadImages() {
    dbGet({
      route: "restaurant",
      params: {
        restaurant_id: params.restaurant_id,
        restaurant_images: "",
      },
    }).then((data) => {
      setImages(data[0].restaurant_images);
    });
  }

  async function handleClick() {
    // upload.name = params.restaurant_id + upload.name;
    const formData = new FormData();
    formData.append("myFile", upload);
    const importFile = await axios.post("http://localhost:3000/api/uploadfile", formData, {
      headers: {
        "content-type": "multipart/form-data",
      },
    });
    if (importFile.status === 200) {
      console.log(importFile);
      loadImages();
    }
  }

  useEffect(() => {
    if (params.restaurant_id !== "") loadImages();
  }, [params.restaurant_id]);

  return (
    <div>
      <form>
        <input
          type="file"
          onChange={(e) => {
            setUpload(e.target.files[0]);
          }}
        />
        <Button
          onClick={() => {
            handleClick();
          }}
        >
          Upload
        </Button>
      </form>
    </div>
  );
}
