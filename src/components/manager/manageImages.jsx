import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField, Snackbar, MenuItem, FormControl, Select } from "@mui/material";
// import MenuItem from "@mui/material/MenuItem";
// import FormControl from "@mui/material/FormControl";
// import Select from "@mui/material/Select";
import InputLabel from "@mui/material/InputLabel";
import ListItemText from "@mui/material/ListItemText";
import Checkbox from "@mui/material/Checkbox";  
import OutlinedInput from "@mui/material/OutlinedInput";
import Card from "@mui/material/Card";
import CardHeader from "@mui/material/CardHeader";
import CardMedia from "@mui/material/CardMedia";
import CardContent from "@mui/material/CardContent";
import CardActions from "@mui/material/CardActions";
import { useEffect, useState } from "react";
import { dbGet, dbPut, dbPost } from "../../api/database";
import axios from "axios";
import "../../../src/App.css";
import { Login } from "@mui/icons-material";

export default function ManageImages(params) {
  const [images, setImages] = useState([]);
  const [upload, setUpload] = useState([]);
  const [open, setOpen] = useState(false);
  const [message, setMessage] = useState("");

  function loadImages() {
    dbGet({
      route: "restaurant_image",
      params: {
        restaurant_image_id: "",
        restaurant_id: params.restaurant_id,
        restaurant_image_name: "",
      },
    }).then((data) => {
      setImages(data);
    });
  }

  async function handleClick() {
    const formData = new FormData();
    formData.append("myFile", upload);
    formData.append("newFileName", "test" + params.restaurant_id);
    const newFileName = `${params.restaurant_id}${images.length + 1}.${upload.name.split(".")[1]}`;
    const importFile = await axios.post("http://localhost:3000/api/uploadfile", formData, {
      headers: {
        "content-type": "multipart/form-data",
        newFileName: newFileName,
      },
    });
    if (importFile.status === 200) {
      const imageData = new FormData();
      imageData.append("restaurant_id", params.restaurant_id);
      imageData.append("restaurant_image_name", newFileName);
      const request = await dbPost("restaurant_image", imageData);
      if (request) {
        setMessage("Image ajoutée avec succès");
        setOpen(true);
        setTimeout(() => {
          setOpen(false);
        }, 2000);
        loadImages();
      }
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
      <div
        id="imageDiv"
        style={{
          display: "flex",
          flexWrap: "wrap",
          justifyContent: "center",
          gap: "50px",
          // alignItems: "center",
          // alignContent: "center",
          // marginLeft: 5,
          // marginTop: 5,
        }}
      >
        {
          // images &&
          images?.map((image) => {
            return (
              <Box
                component="img"
                sx={{
                  height: 233,
                  width: 350,
                  maxHeight: { xs: 233, md: 167 },
                  maxWidth: { xs: 350, md: 250 },
                  // marginRight: 5,
                  // marginTop: 5,
                }}
                alt="The house from the offer."
                src={`../../restaurant_images/${image.restaurant_image_name}`}
              />
              //         <Card sx={{ maxWidth: 345 }}>
              // {/* <CardHeader
              //   avatar={
              //     <Avatar sx={{ bgcolor: red[500] }} aria-label="recipe">
              //       R
              //     </Avatar>
              //   }
              //   action={
              //     <IconButton aria-label="settings">
              //       <MoreVertIcon />
              //     </IconButton>
              //   }
              //   title="Shrimp and Chorizo Paella"
              //   subheader="September 14, 2016"
              // /> */}
              // <CardMedia
              //   component="img"
              //   height="194"
              //   weight="345"
              //   image={`../../restaurant_images/${image.restaurant_image_name}`}
              //   alt="Paella dish"
              // />
              // </Card>
            );
          })
        }
      </div>
      <Snackbar open={open} autoHideDuration={3000} message={message} />
    </div>
  );
}
