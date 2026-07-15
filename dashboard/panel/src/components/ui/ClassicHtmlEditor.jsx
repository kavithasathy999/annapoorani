import { useEffect, useState } from 'react';
import SunEditor from 'suneditor-react';
import 'suneditor/dist/css/suneditor.min.css';

const TOOLBAR_BUTTONS = [
  ['undo', 'redo'],
  ['font', 'fontSize', 'formatBlock'],
  ['bold', 'italic', 'underline'],
  ['fontColor', 'hiliteColor'],
  ['outdent', 'indent', 'list', 'align'],
  ['table', 'link', 'image', 'video'],
  ['removeFormat', 'fullScreen', 'codeView', 'preview'],
];

const FONT_FAMILIES = [
  'Arial',
  'Verdana',
  'Tahoma',
  'Trebuchet MS',
  'Georgia',
  'Times New Roman',
  'Courier New',
];

const FONT_SIZES = [10, 12, 14, 16, 18, 22, 28, 36];

const readFileAsDataUrl = (file) =>
  new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(typeof reader.result === 'string' ? reader.result : '');
    reader.onerror = () => reject(new Error('Unable to prepare the selected file.'));
    reader.readAsDataURL(file);
  });

const createMediaUploadResult = async (files = []) => {
  const result = await Promise.all(
    files.map(async (file) => ({
      url: await readFileAsDataUrl(file),
      name: file.name,
      size: file.size,
    }))
  );

  return { result };
};

const baseEditorOptions = {
  buttonList: TOOLBAR_BUTTONS,
  font: FONT_FAMILIES,
  fontSize: FONT_SIZES,
  fontSizeUnit: 'px',
  formats: ['p', 'h1', 'h2', 'h3', 'h4'],
  alignItems: ['left', 'center', 'right', 'justify'],
  defaultTag: 'p',
  defaultStyle: "font-family: 'DM Sans', sans-serif; font-size: 16px;",
  showPathLabel: false,
  resizingBar: false,
  resizeEnable: false,
  imageFileInput: true,
  imageUrlInput: true,
  videoFileInput: true,
  videoUrlInput: true,
  popupDisplay: 'local',
};

export const ClassicHtmlEditor = ({
  label,
  value,
  onChange,
  disabled = false,
  placeholder = 'Write terms and conditions here...',
  height = '540px',
  onPendingStateChange,
}) => {
  const [isProcessingMedia, setIsProcessingMedia] = useState(false);

  useEffect(() => {
    onPendingStateChange?.(isProcessingMedia);
  }, [isProcessingMedia, onPendingStateChange]);

  const handleMediaUploadBefore = async (files, uploadHandler, typeLabel) => {
    const fileList = Array.from(files || []);

    if (fileList.length === 0) {
      return true;
    }

    try {
      setIsProcessingMedia(true);
      const response = await createMediaUploadResult(fileList);
      uploadHandler(response);
    } catch (error) {
      uploadHandler(error.message || `Unable to insert ${typeLabel}.`);
    } finally {
      setIsProcessingMedia(false);
    }

    return undefined;
  };

  return (
    <div className="terms-editor-shell flex w-full flex-col gap-2">
      {label ? <label className="text-sm font-medium text-slate-700 dark:text-slate-300">{label}</label> : null}
      <SunEditor
        disable={disabled}
        height={height}
        placeholder={placeholder}
        setContents={value}
        onChange={onChange}
        onImageUploadBefore={(files, _info, uploadHandler) =>
          handleMediaUploadBefore(files, uploadHandler, 'image')
        }
        onVideoUploadBefore={(files, _info, uploadHandler) =>
          handleMediaUploadBefore(files, uploadHandler, 'video')
        }
        setOptions={{
          ...baseEditorOptions,
          height,
        }}
      />
    </div>
  );
};
