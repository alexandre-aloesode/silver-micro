import { createBrowserRouter, RouterProvider } from "react-router-dom";
// import ProductList from "../productList.jsx";
// import ProductPage from "../product.jsx";
import UserLogin from "../components/login.jsx";
import UserRegister from "../components/register.jsx";
// import DisplayResearch from "../displayResearch.jsx";
import { redirect } from "react-router-dom";
import Home from "../home.jsx";


export const AppRouterProvider = () => {

const AppRouter = createBrowserRouter([
    {
      path: "/",
      element: <Home />,
    },
    // { path: "/products", element: <ProductList /> },
    { path: "/login", element: <UserLogin /> },
    { path: "/register", element: <UserRegister /> },
    // { path: "/product/:productID", element: <ProductPage /> },
    // {path: "/search/:productName", element: <DisplayResearch />}
  ]);

  return (
    <RouterProvider router={AppRouter} />
  )
}



