import { type FC } from 'react'
import { Link } from 'react-router'
import {
  Box,
  Button,
  MuiContainer,
  Typography
} from '@/components/ui/material-ui'
import { Home as HomeIcon } from '@mui/icons-material'

import { path } from '@/constants/application'

export const NotFound: FC = () => {
  return (
    <Box
      sx={{
        minHeight: '100vh',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        bgcolor: 'grey.100',
      }}
    >
      <MuiContainer maxWidth="sm">
        <Box sx={{ textAlign: 'center' }}>
          <Typography
            variant="h1"
            sx={{
              fontSize: { xs: '4rem', md: '6rem' },
              fontWeight: 'bold',
              color: 'primary.main',
              mb: 2,
            }}
          >
            404
          </Typography>
          
          <Typography variant="h5" color="text.secondary" sx={{ mb: 4 }}>
            お探しのページが見つかりませんでした
          </Typography>
          
          <Button
            component={Link}
            to={path.root()}
            variant="contained"
            size="large"
            startIcon={<HomeIcon />}
            sx={{ py: 1.5, px: 4 }}
          >
            ホームに戻る
          </Button>
        </Box>
      </MuiContainer>
    </Box>
  )
}

