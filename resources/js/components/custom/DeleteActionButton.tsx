import { Button } from '@/components/ui/button';
import useDeleteDialogStore from '@/stores/useDeleteDialogStore';
import { useForm } from '@inertiajs/react';
import { LoadingTextSwap } from './LoadingTextSwap';

type DeleteActionButtonProps = {
  route: string;
  buttonSize?: 'default' | 'sm' | 'lg' | 'icon';
  buttonText?: string;
  requireConfirm?: boolean;
};

export default function DeleteActionButton({ route, buttonSize = 'sm', buttonText = 'Delete', requireConfirm = true }: DeleteActionButtonProps) {
  const { delete: destroy, processing: isDeleting } = useForm();
  const { openDialog, closeDialog } = useDeleteDialogStore();

  const onConfirm = () => {
    destroy(route, {
      preserveScroll: true,
      async: true,
      onFinish: () => {
        closeDialog();
      },
    });
  };

  return (
    <Button
      className="cursor-pointer"
      variant="destructive"
      size={buttonSize}
      onClick={() => {
        // eslint-disable-next-line @typescript-eslint/no-unused-expressions
        requireConfirm ? openDialog(onConfirm) : onConfirm();
      }}
      disabled={isDeleting}
    >
      {requireConfirm ? buttonText : <LoadingTextSwap isLoading={isDeleting}>{buttonText}</LoadingTextSwap>}
    </Button>
  );
}
