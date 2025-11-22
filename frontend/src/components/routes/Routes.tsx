import { useRoutes } from 'react-router'

import { Container } from '@/components/layout/Container'
import { NotFound } from '@/components/pages/Error'
import { path } from '@/constants/application'

export const Routes = () =>
  useRoutes([
    {
      path: path.root(),
      element: <Container />,
      children: [
        {
          index: true,
          element: <Home />,
        },
        {
          path: path.login(),
          element: <Login />,
        }
      ],
    },
    {
      path: '*',
      element: <NotFound />,
    },
  ])
